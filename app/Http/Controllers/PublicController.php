<?php
namespace App\Http\Controllers;
use App\Models\{Setting, Announcement, Hero, HeroStat, About, AlumniChip, OnlineSection, OnlineFeature, Course, EnrollmentSection, EnrollmentStep, EnrollmentRequirement, Gallery, AlumniShowcase, ContactInfo, Footer, SocialLink, ContactMessage, Page};
use Illuminate\Http\Request;

class PublicController extends Controller {
    private function sharedData(): array {
        return [
            'footer'      => Footer::first(),
            'socialLinks' => SocialLink::where('is_active', true)->orderBy('sort_order')->get(),
            'courses'     => Course::where('is_active', true)->orderBy('sort_order')->get(),
            'online'      => OnlineSection::first(),
            'siteName'    => Setting::get('site_name', "Slim's Fashion & Arts School"),
            'siteTagline' => Setting::get('site_tagline', 'School · Est. 1962'),
        ];
    }

    public function index() {
        return view('public.home', array_merge($this->sharedData(), [
            'announcement'   => Announcement::first(),
            'hero'           => Hero::first(),
            'heroStats'      => HeroStat::orderBy('sort_order')->get(),
            'about'          => About::first(),
            'alumniChips'    => AlumniChip::orderBy('sort_order')->get(),
            'onlineFeatures' => OnlineFeature::orderBy('sort_order')->get(),
            'enrollment'     => EnrollmentSection::first(),
            'steps'          => EnrollmentStep::orderBy('sort_order')->get(),
            'requirements'   => EnrollmentRequirement::orderBy('sort_order')->get(),
            'gallery'        => Gallery::where('is_active', true)->orderBy('sort_order')->get(),
            'alumniShowcase' => AlumniShowcase::where('is_active', true)->orderBy('sort_order')->get(),
            'contact'        => ContactInfo::first(),
        ]));
    }

    public function course(string $slug) {
        $course = Course::with('modules.submodules')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        return view('public.course', array_merge($this->sharedData(), compact('course')));
    }

    public function page(string $slug) {
        $page = Page::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('public.page', array_merge($this->sharedData(), compact('page')));
    }

    public function contact(Request $request) {
        $data = $request->validate([
            'first_name'   => 'required|string|max:80',
            'last_name'    => 'required|string|max:80',
            'email'        => 'required|email|max:180',
            'inquiry_type' => 'nullable|string|max:80',
            'message'      => 'required|string|max:3000',
        ]);
        $data['ip_address'] = $request->ip();
        ContactMessage::create($data);
        return back()->with('contact_success', 'Your message has been sent! We will be in touch shortly.');
    }
}
