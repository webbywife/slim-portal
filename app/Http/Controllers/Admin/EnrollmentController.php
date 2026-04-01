<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{EnrollmentSection, EnrollmentStep, EnrollmentRequirement};
use Illuminate\Http\Request;

class EnrollmentController extends Controller {
    public function index() {
        return view('admin.enrollment.index', [
            'section'      => EnrollmentSection::first(),
            'steps'        => EnrollmentStep::orderBy('sort_order')->get(),
            'requirements' => EnrollmentRequirement::orderBy('sort_order')->get(),
        ]);
    }
    public function update(Request $request) {
        $d = $request->validate([
            'section_label' => 'nullable|string|max:80',
            'heading'       => 'required|string|max:255',
            'body_text'     => 'required|string',
            'req_card_title'=> 'nullable|string|max:150',
            'req_note'      => 'nullable|string',
            'cta_text'      => 'nullable|string|max:80',
            'cta_url'       => 'nullable|string|max:255',
        ]);
        EnrollmentSection::updateOrCreate(['id' => 1], $d);
        // Steps
        EnrollmentStep::truncate();
        foreach ($request->input('steps', []) as $i => $s) {
            if (!empty($s['step_title'])) EnrollmentStep::create(['step_title' => $s['step_title'], 'step_desc' => $s['step_desc'] ?? '', 'sort_order' => $i]);
        }
        // Requirements
        EnrollmentRequirement::truncate();
        foreach ($request->input('requirements', []) as $i => $r) {
            if (trim($r)) EnrollmentRequirement::create(['requirement' => $r, 'sort_order' => $i]);
        }
        return back()->with('success', 'Enrollment section updated.');
    }
}
