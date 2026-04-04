<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MoodleService
{
    private string $baseUrl;
    private string $token;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('moodle.url'), '/');
        $this->token   = config('moodle.token');
    }

    private function call(string $function, array $params = []): mixed
    {
        $response = Http::asForm()->post("{$this->baseUrl}/webservice/rest/server.php", array_merge([
            'wstoken'               => $this->token,
            'wsfunction'            => $function,
            'moodlewsrestformat'    => 'json',
        ], $params));

        $data = $response->json();

        if (isset($data['exception'])) {
            Log::error("Moodle API error [{$function}]: " . ($data['message'] ?? json_encode($data)));
            throw new \RuntimeException("Moodle API error: " . ($data['message'] ?? $function));
        }

        return $data;
    }

    // Create or update a Moodle user; returns moodle user id
    public function syncUser(string $firstname, string $lastname, string $email, string $moodlePassword): int
    {
        // Check if user already exists
        $existing = $this->call('core_user_get_users_by_field', [
            'field'    => 'email',
            'values[0]' => $email,
        ]);

        if (!empty($existing) && isset($existing[0]['id'])) {
            return (int) $existing[0]['id'];
        }

        // Create user
        $result = $this->call('core_user_create_users', [
            'users[0][username]'   => strtolower(str_replace(['@', '.', ' '], ['_at_', '_', '_'], $email)),
            'users[0][password]'   => $moodlePassword,
            'users[0][firstname]'  => $firstname,
            'users[0][lastname]'   => $lastname,
            'users[0][email]'      => $email,
            'users[0][auth]'       => 'manual',
        ]);

        return (int) $result[0]['id'];
    }

    // Enroll user in a Moodle course (role 5 = student)
    public function enrollUser(int $moodleUserId, int $moodleCourseId, int $roleId = 5): void
    {
        $this->call('enrol_manual_enrol_users', [
            'enrolments[0][roleid]'   => $roleId,
            'enrolments[0][userid]'   => $moodleUserId,
            'enrolments[0][courseid]' => $moodleCourseId,
        ]);
    }

    // Get all courses
    public function getCourses(): array
    {
        $courses = $this->call('core_course_get_courses', []);
        // Filter out site course (id=1)
        return array_filter($courses, fn($c) => $c['id'] != 1);
    }

    // Get courses a user is enrolled in
    public function getUserCourses(int $moodleUserId): array
    {
        return $this->call('core_enrol_get_users_courses', [
            'userid' => $moodleUserId,
        ]);
    }

    // Build SSO auto-login URL (POST-based via a relay controller)
    public function getSSORelayUrl(int $moodleUserId, string $moodlePassword, string $redirect = ''): string
    {
        $moodleUser = $this->getMoodleUser($moodleUserId);
        return route('lms.sso', [
            'u' => $moodleUser['username'] ?? '',
            'p' => base64_encode($moodlePassword),
            'r' => $redirect ?: '/my',
        ]);
    }

    public function getMoodleUser(int $moodleUserId): array
    {
        $result = $this->call('core_user_get_users', [
            'criteria[0][key]'   => 'id',
            'criteria[0][value]' => $moodleUserId,
        ]);
        return $result['users'][0] ?? [];
    }

    public function getLmsUrl(): string
    {
        return $this->baseUrl;
    }
}
