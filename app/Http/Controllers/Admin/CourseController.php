<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Course, CourseModule, CourseSubmodule};
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
        if (empty($data['slug'])) $data['slug'] = Course::generateSlug($data['course_name']);
        if ($request->hasFile('course_image')) {
            $data['course_image'] = $request->file('course_image')->store('courses', 'public');
        }
        $course = Course::create($data);
        $this->saveModules($request, $course);
        return redirect()->route('admin.courses.index')->with('success', 'Course created.');
    }
    public function edit(Course $course) {
        $course->load('modules.submodules');
        return view('admin.courses.form', compact('course'));
    }
    public function update(Request $request, Course $course) {
        $data = $this->validated($request, $course->id);
        if (empty($data['slug'])) $data['slug'] = Course::generateSlug($data['course_name'], $course->id);
        if ($request->hasFile('course_image')) {
            if ($course->course_image) Storage::disk('public')->delete($course->course_image);
            $data['course_image'] = $request->file('course_image')->store('courses', 'public');
        } else {
            unset($data['course_image']);
        }
        $course->update($data);
        $this->saveModules($request, $course);
        return redirect()->route('admin.courses.index')->with('success', 'Course updated.');
    }
    public function destroy(Course $course) {
        if ($course->course_image) Storage::disk('public')->delete($course->course_image);
        $course->delete();
        return back()->with('success', 'Course deleted.');
    }

    private function saveModules(Request $request, Course $course): void {
        $course->modules()->each(fn($m) => $m->submodules()->delete());
        $course->modules()->delete();

        foreach ($request->input('modules', []) as $i => $m) {
            if (empty($m['title'])) continue;
            $module = CourseModule::create([
                'course_id'    => $course->id,
                'title'        => $m['title'],
                'prerequisite' => $m['prerequisite'] ?? null,
                'sessions'     => $m['sessions'] ?? null,
                'description'  => $m['description'] ?? null,
                'tuition_fee'  => $m['tuition_fee'] ?? null,
                'materials_fee'=> $m['materials_fee'] ?? null,
                'sort_order'   => $i,
            ]);
            foreach ($m['submodules'] ?? [] as $j => $s) {
                if (empty($s['title'])) continue;
                CourseSubmodule::create([
                    'module_id'   => $module->id,
                    'title'       => $s['title'],
                    'description' => $s['description'] ?? null,
                    'sort_order'  => $j,
                ]);
            }
        }
    }

    private function validated(Request $r, ?int $exceptId = null): array {
        return $r->validate([
            'category_tag'  => 'nullable|string|max:80',
            'course_name'   => 'required|string|max:150',
            'slug'          => ['nullable','string','max:150','unique:courses,slug'.($exceptId ? ",$exceptId" : '')],
            'description'   => 'required|string',
            'duration'      => 'nullable|string|max:60',
            'card_gradient' => 'nullable|string|max:150',
            'course_image'  => 'nullable|image|max:5120',
            'is_active'     => 'boolean',
            'sort_order'    => 'nullable|integer',
        ]) + ['is_active' => $r->boolean('is_active')];
    }
}
