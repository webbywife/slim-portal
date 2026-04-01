<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Announcement, Hero, HeroStat, About, AlumniChip, OnlineSection, OnlineFeature};
use Illuminate\Http\Request;

class ContentController extends Controller {
    public function index() {
        return view('admin.content.index', [
            'announcement'   => Announcement::first(),
            'hero'           => Hero::first(),
            'heroStats'      => HeroStat::orderBy('sort_order')->get(),
            'about'          => About::first(),
            'alumniChips'    => AlumniChip::orderBy('sort_order')->get(),
            'online'         => OnlineSection::first(),
            'onlineFeatures' => OnlineFeature::orderBy('sort_order')->get(),
        ]);
    }

    public function update(Request $request, string $section) {
        match($section) {
            'announcement' => $this->saveAnnouncement($request),
            'hero'         => $this->saveHero($request),
            'hero-stats'   => $this->saveHeroStats($request),
            'about'        => $this->saveAbout($request),
            'alumni-chips' => $this->saveAlumniChips($request),
            'online'       => $this->saveOnline($request),
            default        => abort(404),
        };
        return back()->with('success', ucfirst($section) . ' updated successfully.');
    }

    private function saveAnnouncement(Request $r): void {
        $d = $r->validate(['content_html' => 'required|string', 'is_active' => 'boolean']);
        $d['is_active'] = $r->boolean('is_active');
        Announcement::updateOrCreate(['id' => 1], $d);
    }

    private function saveHero(Request $r): void {
        $d = $r->validate([
            'eyebrow' => 'required|string|max:200',
            'headline_main' => 'required|string|max:200',
            'headline_em' => 'required|string|max:200',
            'subheadline' => 'required|string',
            'cta_primary_text' => 'required|string|max:80',
            'cta_primary_url' => 'required|string|max:255',
            'cta_secondary_text' => 'required|string|max:80',
            'cta_secondary_url' => 'required|string|max:255',
            'seal_year' => 'nullable|string|max:20',
            'seal_name' => 'nullable|string|max:80',
            'seal_tagline' => 'nullable|string|max:80',
        ]);
        Hero::updateOrCreate(['id' => 1], $d);
    }

    private function saveHeroStats(Request $r): void {
        HeroStat::truncate();
        foreach ($r->input('stats', []) as $i => $s) {
            if (!empty($s['stat_value'])) {
                HeroStat::create(['stat_value' => $s['stat_value'], 'stat_label' => $s['stat_label'] ?? '', 'sort_order' => $i]);
            }
        }
    }

    private function saveAbout(Request $r): void {
        $d = $r->validate([
            'section_label' => 'nullable|string|max:80',
            'heading_main'  => 'required|string|max:255',
            'heading_em'    => 'required|string|max:255',
            'body_para1'    => 'required|string',
            'body_para2'    => 'required|string',
            'quote_text'    => 'required|string',
            'quote_cite'    => 'nullable|string|max:200',
            'badge_number'  => 'nullable|string|max:20',
            'badge_text'    => 'nullable|string|max:100',
        ]);
        About::updateOrCreate(['id' => 1], $d);
    }

    private function saveAlumniChips(Request $r): void {
        AlumniChip::truncate();
        foreach ($r->input('chips', []) as $i => $label) {
            if (trim($label)) AlumniChip::create(['label' => $label, 'sort_order' => $i]);
        }
    }

    private function saveOnline(Request $r): void {
        $d = $r->validate([
            'section_label'       => 'nullable|string|max:80',
            'heading_line1'       => 'required|string|max:200',
            'heading_line2'       => 'required|string|max:200',
            'body_text'           => 'required|string',
            'cta_primary_text'    => 'required|string|max:80',
            'cta_primary_url'     => 'required|string|max:255',
            'cta_secondary_text'  => 'required|string|max:80',
            'cta_secondary_url'   => 'required|string|max:255',
            'platform_name'       => 'required|string|max:80',
            'platform_tagline'    => 'nullable|string|max:100',
            'platform_url'        => 'required|string|max:255',
        ]);
        OnlineSection::updateOrCreate(['id' => 1], $d);
        OnlineFeature::truncate();
        foreach ($r->input('features', []) as $i => $f) {
            if (!empty($f['feature_title'])) {
                OnlineFeature::create(['feature_title' => $f['feature_title'], 'feature_sub' => $f['feature_sub'] ?? '', 'sort_order' => $i]);
            }
        }
    }
}
