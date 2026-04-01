<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller {
    public function index() {
        return view('admin.courses.index', ['courses' => Course::orderBy('sort_order')->get()]);
    }
    public function create() {
        return view('admin.courses.form', ['course' => new Course]);
    }
    public function store(Request $request) {
        $data = $this->validated($request);
        if ($request->hasFile('course_image')) {
            $data['course_image'] = $request->file('course_image')->store('courses', 'public');
        }
        Course::create($data);
        return redirect()->route('admin.courses.index')->with('success', 'Course created.');
    }
    public function edit(Course $course) {
        return view('admin.courses.form', compact('course'));
    }
    public function update(Request $request, Course $course) {
        $data = $this->validated($request);
        if ($request->hasFile('course_image')) {
            if ($course->course_image) Storage::disk('public')->delete($course->course_image);
            $data['course_image'] = $request->file('course_image')->store('courses', 'public');
        } else {
            unset($data['course_image']);
        }
        $course->update($data);
        return redirect()->route('admin.courses.index')->with('success', 'Course updated.');
    }
    public function destroy(Course $course) {
        if ($course->course_image) Storage::disk('public')->delete($course->course_image);
        $course->delete();
        return back()->with('success', 'Course deleted.');
    }
    private function validated(Request $r): array {
        return $r->validate([
            'category_tag'  => 'nullable|string|max:80',
            'course_name'   => 'required|string|max:150',
            'description'   => 'required|string',
            'duration'      => 'nullable|string|max:60',
            'card_gradient' => 'nullable|string|max:150',
            'course_image'  => 'nullable|image|max:5120',
            'is_active'     => 'boolean',
            'sort_order'    => 'nullable|integer',
        ]) + ['is_active' => $r->boolean('is_active')];
    }
}
