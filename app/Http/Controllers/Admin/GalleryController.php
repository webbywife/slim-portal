<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Gallery, AlumniShowcase};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller {
    public function index() {
        return view('admin.gallery.index', [
            'items'   => Gallery::orderBy('sort_order')->get(),
            'alumni'  => AlumniShowcase::orderBy('sort_order')->get(),
        ]);
    }
    public function store(Request $request) {
        $request->validate(['image' => 'required|image|max:5120', 'caption' => 'nullable|string|max:200', 'span_type' => 'in:normal,tall,wide']);
        $path = $request->file('image')->store('gallery', 'public');
        Gallery::create([
            'file_path'  => $path,
            'caption'    => $request->input('caption', ''),
            'span_type'  => $request->input('span_type', 'normal'),
            'alt_text'   => $request->input('caption', ''),
            'sort_order' => Gallery::max('sort_order') + 1,
        ]);
        return back()->with('success', 'Image uploaded.');
    }
    public function update(Request $request, int $id) {
        $item = Gallery::findOrFail($id);
        $item->update($request->only(['caption','span_type','alt_text','is_active','sort_order']));
        return back()->with('success', 'Gallery item updated.');
    }
    public function destroy(int $id) {
        $item = Gallery::findOrFail($id);
        if ($item->file_path) Storage::disk('public')->delete($item->file_path);
        $item->delete();
        return back()->with('success', 'Image deleted.');
    }
}
