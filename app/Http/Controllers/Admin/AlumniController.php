<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\AlumniShowcase;
use Illuminate\Http\Request;

class AlumniController extends Controller {
    public function index() {
        return view('admin.alumni.index', ['alumni' => AlumniShowcase::orderBy('sort_order')->get()]);
    }
    public function store(Request $request) {
        $d = $request->validate(['alumni_name' => 'required|string|max:150', 'alumni_role' => 'required|string|max:150', 'sort_order' => 'nullable|integer']);
        AlumniShowcase::create($d);
        return back()->with('success', 'Alumni added.');
    }
    public function update(Request $request, int $id) {
        AlumniShowcase::findOrFail($id)->update($request->validate(['alumni_name' => 'required|string|max:150', 'alumni_role' => 'required|string|max:150', 'sort_order' => 'nullable|integer', 'is_active' => 'boolean']) + ['is_active' => $request->boolean('is_active')]);
        return back()->with('success', 'Alumni updated.');
    }
    public function destroy(int $id) {
        AlumniShowcase::findOrFail($id)->delete();
        return back()->with('success', 'Alumni deleted.');
    }
}
