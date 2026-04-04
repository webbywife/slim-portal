<?php
namespace App\Http\Controllers;

use App\Models\EnrollmentApplication;
use App\Models\Course;
use App\Services\MoodleService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MoodleController extends Controller
{
    public function __construct(private MoodleService $moodle) {}

    // Public: LMS landing page showing available Moodle courses
    public function index()
    {
        try {
            $courses = collect($this->moodle->getCourses());
        } catch (\Throwable $e) {
            $courses = collect();
        }
        return view('lms.index', compact('courses'));
    }

    // Public: Enrollment application form
    public function applyForm(Request $req)
    {
        $courses = Course::where('is_active', true)->orderBy('sort_order')->get();
        return view('lms.apply', compact('courses'));
    }

    // Public: Handle enrollment form submission
    public function applySubmit(Request $req)
    {
        $data = $req->validate([
            'firstname'  => 'required|string|max:100',
            'lastname'   => 'required|string|max:100',
            'email'      => 'required|email|max:255',
            'phone'      => 'nullable|string|max:30',
            'course_id'  => 'nullable|exists:courses,id',
        ]);

        $app = EnrollmentApplication::create($data);

        // Try to create Moodle user immediately
        try {
            $password = Str::random(12) . '!A1';
            $moodleId = $this->moodle->syncUser(
                $data['firstname'],
                $data['lastname'],
                $data['email'],
                $password
            );
            $app->update([
                'moodle_user_id' => $moodleId,
                'status'         => 'approved',
            ]);
        } catch (\Throwable $e) {
            // Non-fatal: enrollment stored, Moodle sync can happen later
        }

        return back()->with('success', 'Your enrollment application has been submitted! We will be in touch shortly.');
    }

    // SSO relay: auto-login user to Moodle via hidden form POST
    public function sso(Request $req)
    {
        $username = $req->query('u');
        $password = base64_decode($req->query('p', ''));
        $redirect = $req->query('r', '/my');
        $lmsUrl   = $this->moodle->getLmsUrl();

        return view('lms.sso', compact('username', 'password', 'redirect', 'lmsUrl'));
    }

    // Admin: list enrollment applications
    public function adminApplications()
    {
        $apps = EnrollmentApplication::with('course')->latest()->paginate(20);
        return view('admin.lms.applications', compact('apps'));
    }

    // Admin: approve + enroll in Moodle course
    public function adminApprove(Request $req, EnrollmentApplication $app)
    {
        $req->validate(['moodle_course_id' => 'required|integer']);

        try {
            $password = $app->moodle_user_id ? null : Str::random(12) . '!A1';

            if (!$app->moodle_user_id) {
                $moodleId = $this->moodle->syncUser(
                    $app->firstname, $app->lastname, $app->email, $password
                );
                $app->update(['moodle_user_id' => $moodleId]);
            }

            $this->moodle->enrollUser($app->moodle_user_id, (int) $req->moodle_course_id);
            $app->update(['status' => 'approved']);

            return back()->with('success', "Enrolled {$app->full_name} in Moodle course.");
        } catch (\Throwable $e) {
            return back()->with('error', 'Moodle enrollment failed: ' . $e->getMessage());
        }
    }

    // Admin: get Moodle courses for dropdown
    public function adminMoodleCourses()
    {
        try {
            return response()->json($this->moodle->getCourses());
        } catch (\Throwable $e) {
            return response()->json([], 500);
        }
    }
}
