<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\MoodleController;

// Public site
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::post('/contact', [PublicController::class, 'contact'])->name('contact.submit');
Route::get('/page/{slug}', [PublicController::class, 'page'])->name('page.show');
Route::get('/courses/{slug}', [PublicController::class, 'course'])->name('course.show');

// LMS public pages
Route::get('/lms', [MoodleController::class, 'index'])->name('lms.index');
Route::get('/lms/apply', [MoodleController::class, 'applyForm'])->name('lms.apply');
Route::post('/lms/apply', [MoodleController::class, 'applySubmit'])->name('lms.apply.submit');
Route::get('/lms/sso', [MoodleController::class, 'sso'])->name('lms.sso');

// Auth
Route::get('/admin/login',   [LoginController::class, 'showForm'])->name('login');
Route::post('/admin/login',  [LoginController::class, 'login'])->name('login.post');
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('logout');

// Admin — any logged-in user
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/',                    [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Content (hero, about, online, announcement)
    Route::get('/content',             [Admin\ContentController::class, 'index'])->name('content.index');
    Route::post('/content/{section}',  [Admin\ContentController::class, 'update'])->name('content.update');

    // Courses
    Route::resource('courses', Admin\CourseController::class)->except(['show']);

    // Pages
    Route::resource('pages', Admin\PageController::class)->except(['show']);

    // Gallery
    Route::get('/gallery',             [Admin\GalleryController::class, 'index'])->name('gallery.index');
    Route::post('/gallery',            [Admin\GalleryController::class, 'store'])->name('gallery.store');
    Route::post('/gallery/{id}/update',[Admin\GalleryController::class, 'update'])->name('gallery.update');
    Route::delete('/gallery/{id}',     [Admin\GalleryController::class, 'destroy'])->name('gallery.destroy');

    // Enrollment
    Route::get('/enrollment',          [Admin\EnrollmentController::class, 'index'])->name('enrollment.index');
    Route::post('/enrollment',         [Admin\EnrollmentController::class, 'update'])->name('enrollment.update');

    // Alumni
    Route::get('/alumni',              [Admin\AlumniController::class, 'index'])->name('alumni.index');
    Route::post('/alumni',             [Admin\AlumniController::class, 'store'])->name('alumni.store');
    Route::put('/alumni/{id}',         [Admin\AlumniController::class, 'update'])->name('alumni.update');
    Route::delete('/alumni/{id}',      [Admin\AlumniController::class, 'destroy'])->name('alumni.destroy');

    // Messages
    Route::get('/messages',            [Admin\MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages/{id}/read', [Admin\MessageController::class, 'markRead'])->name('messages.read');
    Route::delete('/messages/{id}',    [Admin\MessageController::class, 'destroy'])->name('messages.destroy');

    // Settings (contact, footer, social)
    Route::get('/settings',            [Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings/{section}', [Admin\SettingController::class, 'update'])->name('settings.update');

    // LMS / Moodle
    Route::get('/lms/applications',                            [MoodleController::class, 'adminApplications'])->name('lms.applications');
    Route::post('/lms/applications/{app}/approve',             [MoodleController::class, 'adminApprove'])->name('lms.approve');
    Route::get('/lms/moodle-courses',                          [MoodleController::class, 'adminMoodleCourses'])->name('lms.moodle-courses');

    // SCORM Tool link (just redirects to the standalone tool)
    Route::get('/scorm-tool',          fn() => redirect('/scorm-tool/index.html'))->name('scorm-tool');
});

// Admin — admin-only routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin:admin'])->group(function () {
    Route::resource('users', Admin\UserController::class)->except(['show']);
});
