<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnrollmentApplication extends Model
{
    protected $fillable = [
        'firstname', 'lastname', 'email', 'phone',
        'course_id', 'status', 'moodle_user_id', 'notes',
    ];

    public function course() {
        return $this->belongsTo(Course::class);
    }

    public function getFullNameAttribute(): string {
        return "{$this->firstname} {$this->lastname}";
    }
}
