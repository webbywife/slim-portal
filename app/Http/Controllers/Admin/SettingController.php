<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{ContactInfo, Footer, SocialLink, Setting};
use Illuminate\Http\Request;

class SettingController extends Controller {
    public function index() {
        return view('admin.settings.index', [
            'contact'     => ContactInfo::first(),
            'footer'      => Footer::first(),
            'socialLinks' => SocialLink::orderBy('sort_order')->get(),
            'siteName'    => Setting::get('site_name', "Slim's Fashion & Arts School"),
            'siteTagline' => Setting::get('site_tagline', 'School · Est. 1962'),
            'moodleUrl'   => Setting::get('moodle_url', 'https://slimsonline.school/moodle'),
        ]);
    }
    public function update(Request $request, string $section) {
        match($section) {
            'contact' => ContactInfo::updateOrCreate(['id' => 1], $request->validate([
                'email' => 'required|email|max:180', 'phone' => 'nullable|string|max:60',
                'address' => 'nullable|string|max:255', 'office_hours' => 'nullable|string|max:150',
            ])),
            'footer' => Footer::updateOrCreate(['id' => 1], $request->validate([
                'brand_name' => 'required|string|max:150', 'brand_sub' => 'nullable|string|max:200',
                'brand_blurb' => 'required|string', 'copyright_text' => 'required|string|max:255',
            ])),
            'social' => $this->saveSocialLinks($request),
            'global' => $this->saveGlobal($request),
            default  => abort(404),
        };
        return back()->with('success', ucfirst($section) . ' settings saved.');
    }
    private function saveSocialLinks(Request $r): void {
        SocialLink::truncate();
        foreach ($r->input('links', []) as $i => $l) {
            if (!empty($l['url'])) SocialLink::create(['platform' => $l['platform'] ?? '', 'display_label' => $l['display_label'] ?? '', 'url' => $l['url'], 'sort_order' => $i, 'is_active' => !empty($l['is_active'])]);
        }
    }
    private function saveGlobal(Request $r): void {
        Setting::set('site_name', $r->input('site_name', ''));
        Setting::set('site_tagline', $r->input('site_tagline', ''));
        Setting::set('moodle_url', $r->input('moodle_url', ''));
    }
}
