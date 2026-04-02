<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller {
    public function index() {
        return view('admin.pages.index', ['pages' => Page::orderBy('sort_order')->orderBy('title')->get()]);
    }
    public function create() {
        return view('admin.pages.form', ['page' => new Page]);
    }
    public function store(Request $request) {
        $data = $this->validated($request);
        if (empty($data['slug'])) $data['slug'] = Page::generateSlug($data['title']);
        if ($request->hasFile('hero_image')) {
            $data['hero_image'] = $request->file('hero_image')->store('pages', 'public');
        }
        Page::create($data);
        return redirect()->route('admin.pages.index')->with('success', 'Page created.');
    }
    public function edit(Page $page) {
        return view('admin.pages.form', compact('page'));
    }
    public function update(Request $request, Page $page) {
        $data = $this->validated($request, $page->id);
        if (empty($data['slug'])) $data['slug'] = Page::generateSlug($data['title'], $page->id);
        if ($request->hasFile('hero_image')) {
            if ($page->hero_image) Storage::disk('public')->delete($page->hero_image);
            $data['hero_image'] = $request->file('hero_image')->store('pages', 'public');
        } else {
            unset($data['hero_image']);
        }
        $page->update($data);
        return redirect()->route('admin.pages.index')->with('success', 'Page updated.');
    }
    public function destroy(Page $page) {
        if ($page->hero_image) Storage::disk('public')->delete($page->hero_image);
        $page->delete();
        return back()->with('success', 'Page deleted.');
    }
    private function validated(Request $r, ?int $exceptId = null): array {
        return $r->validate([
            'title'            => 'required|string|max:200',
            'slug'             => ['nullable','string','max:200','regex:/^[a-z0-9\-]+$/','unique:pages,slug' . ($exceptId ? ",$exceptId" : '')],
            'excerpt'          => 'nullable|string|max:300',
            'content'          => 'nullable|string',
            'hero_image'       => 'nullable|image|max:5120',
            'meta_description' => 'nullable|string|max:300',
            'is_active'        => 'boolean',
            'sort_order'       => 'nullable|integer',
        ]) + ['is_active' => $r->boolean('is_active')];
    }
}
