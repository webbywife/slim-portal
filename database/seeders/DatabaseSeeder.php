<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Setting, Announcement, Hero, HeroStat, About, AlumniChip, OnlineSection, OnlineFeature, Course, EnrollmentSection, EnrollmentStep, EnrollmentRequirement, Gallery, AlumniShowcase, ContactInfo, Footer, SocialLink};

class DatabaseSeeder extends Seeder {
    public function run(): void {
        // Admin user
        User::firstOrCreate(['email' => 'admin@slimsfashion.com'], [
            'name' => 'Site Administrator', 'password' => Hash::make('Admin@1234!'), 'role' => 'admin', 'is_active' => true,
        ]);

        // Settings
        $settings = [
            ['site_name',    "Slim's Fashion & Arts School"],
            ['site_tagline', 'School · Est. 1962'],
            ['moodle_url',   'https://slimsonline.school/moodle'],
        ];
        foreach ($settings as [$k, $v]) Setting::firstOrCreate(['key' => $k], ['value' => $v]);

        // Announcement
        Announcement::firstOrCreate(['id' => 1], [
            'content_html' => '<strong>Enroll Now:</strong> New classes starting this term &mdash; <a href="#enrollment">View Requirements</a> or <a href="https://slimsonline.school/moodle" target="_blank" rel="noopener">Join Slims Online</a>',
            'is_active' => true,
        ]);

        // Hero
        Hero::firstOrCreate(['id' => 1], [
            'eyebrow' => "Philippines' Premier Fashion Institution",
            'headline_main' => 'Learning', 'headline_em' => 'Without Borders',
            'subheadline' => "Shaping the finest fashion minds in the Philippines for over six decades. From dressmaking to haute couture design — your creative future begins here.",
            'cta_primary_text' => 'Enroll Now', 'cta_primary_url' => '#enrollment',
            'cta_secondary_text' => 'Slims Online →', 'cta_secondary_url' => 'https://slimsonline.school/moodle',
            'seal_year' => 'Est. 1962', 'seal_name' => "Slim's Fashion & Arts", 'seal_tagline' => 'School',
        ]);
        if (HeroStat::count() === 0) {
            foreach ([['60+','Years of Excellence',0],['10k+','Graduates Nationwide',1],['8','Specialized Programs',2]] as [$v,$l,$o])
                HeroStat::create(['stat_value'=>$v,'stat_label'=>$l,'sort_order'=>$o]);
        }

        // About
        About::firstOrCreate(['id' => 1], [
            'section_label' => 'Our Heritage', 'heading_main' => 'Over Six Decades of Shaping', 'heading_em' => 'Philippine Fashion',
            'body_para1' => "Founded in 1962, Slim's Fashion & Arts School has been a cornerstone of technical fashion education in the Philippines. Through rigorous hands-on training and a curriculum rooted in both classical technique and modern design, we have produced graduates who lead the Philippine fashion industry at home and abroad.",
            'body_para2' => "Our graduates have dressed presidents, adorned runways in Manila and Paris, and built businesses that define Philippine style. Slim's is not merely a school — it is a legacy, stitched into the fabric of this nation's creative identity.",
            'quote_text' => "Slim's gave me the discipline and the craft. Everything else followed.",
            'quote_cite' => "Notable Slim's Alumna, International Fashion Designer",
            'badge_number' => '60+', 'badge_text' => 'Years of Technical Excellence',
        ]);
        if (AlumniChip::count() === 0) {
            foreach (['Fashion Designers','Costume Artists','Bridal Couturiers','Pattern Masters','Textile Entrepreneurs','Style Educators'] as $i => $l)
                AlumniChip::create(['label'=>$l,'sort_order'=>$i]);
        }

        // Online Section
        OnlineSection::firstOrCreate(['id' => 1], [
            'section_label' => 'Digital Campus', 'heading_line1' => "Slim's Online:", 'heading_line2' => 'Fashion Education, Anywhere.',
            'body_text' => "With our Moodle-powered online campus, you can now access Slim's world-class fashion curriculum from anywhere in the Philippines — or across the globe. Learn at your own pace without sacrificing quality.",
            'cta_primary_text' => 'Access Platform', 'cta_primary_url' => 'https://slimsonline.school/moodle',
            'cta_secondary_text' => 'Sign Up Free', 'cta_secondary_url' => 'https://bit.ly/SlimsSignUpNow',
            'platform_name' => 'SlimsOnline', 'platform_tagline' => 'Powered by Moodle LMS', 'platform_url' => 'slimsonline.school/moodle',
        ]);
        if (OnlineFeature::count() === 0) {
            foreach ([['Self-Paced','Learn on your schedule'],['Video Lessons','HD tutorial library'],['Nationwide','Any province, any island'],['Certificate',"Official Slim's credential"]] as $i => [$t,$s])
                OnlineFeature::create(['feature_title'=>$t,'feature_sub'=>$s,'sort_order'=>$i]);
        }

        // Courses
        if (Course::count() === 0) {
            $courses = [
                ['Foundation','Dressmaking','Master the fundamentals of garment construction — from cutting fabric to finishing hems.','3 – 6 Months','linear-gradient(135deg,#C4886B,#8B4513)',0],
                ['Technical','Pattern Making','Learn the precise art of drafting, grading, and modifying patterns.','4 – 8 Months','linear-gradient(135deg,#8B5E83,#4A2040)',1],
                ['Creative','Fashion Design','Explore silhouette, proportion, color, and textile. Develop your personal design language.','6 – 12 Months','linear-gradient(135deg,#6B8E6B,#2E5E2E)',2],
                ['Classic Craft','Tailoring','The refined art of bespoke menswear and structured garments.','4 – 6 Months','linear-gradient(135deg,#B8860B,#5C4000)',3],
                ['Specialization','Bridal Couture','Create breathtaking bridal gowns and formal wear.','5 – 10 Months','linear-gradient(135deg,#D4A0C0,#7B1A4A)',4],
                ['Advanced','Fashion Illustration','Bring your design ideas to life on paper.','2 – 4 Months','linear-gradient(135deg,#6B9EB8,#1A4A6E)',5],
            ];
            foreach ($courses as [$cat,$name,$desc,$dur,$grad,$ord])
                Course::create(['category_tag'=>$cat,'course_name'=>$name,'description'=>$desc,'duration'=>$dur,'card_gradient'=>$grad,'sort_order'=>$ord]);
        }

        // Enrollment
        EnrollmentSection::firstOrCreate(['id' => 1], [
            'section_label' => 'Enrollment', 'heading' => "Begin Your Journey at Slim's",
            'body_text' => "Enrolling at Slim's Fashion & Arts School is simple. Follow these steps and bring the required documents to our admissions office, or complete registration through our online platform.",
            'req_card_title' => 'Enrollment Requirements',
            'req_note' => "Requirements may vary by program. Contact our admissions office or visit Slims Online for the most up-to-date requirements list. Walk-in inquiries are also welcome during office hours (Mon–Sat, 8AM–5PM).",
            'cta_text' => 'Inquire Now', 'cta_url' => '#contact',
        ]);
        if (EnrollmentStep::count() === 0) {
            foreach ([['Choose a Program','Select the course that aligns with your goals.',0],['Prepare Requirements','Gather all required documents.',1],['Visit or Apply Online','Submit in person or through Slims Online.',2],['Pay & Confirm','Complete payment and receive your class schedule.',3]] as [$t,$d,$o])
                EnrollmentStep::create(['step_title'=>$t,'step_desc'=>$d,'sort_order'=>$o]);
        }
        if (EnrollmentRequirement::count() === 0) {
            foreach (['Completed Enrollment Form','2x2 ID Photo (white background, 4 copies)','Photocopy of Birth Certificate (PSA-authenticated)','High School Diploma or Certificate of Completion','Government-issued ID','Certificate of Good Moral Character (for transferees)','Proof of Payment of Enrollment Fee','Medical Certificate (for certain programs)'] as $i => $r)
                EnrollmentRequirement::create(['requirement'=>$r,'sort_order'=>$i]);
        }

        // Gallery placeholders
        if (Gallery::count() === 0) {
            foreach ([['Fashion Show 2024','tall'],['Design Studio','normal'],['Graduation Ceremony','wide'],['Fabric Workshop','normal'],['Pattern Drafting Class','normal'],['Alumni Collection','normal']] as $i => [$cap,$span])
                Gallery::create(['file_path'=>'','caption'=>$cap,'span_type'=>$span,'sort_order'=>$i]);
        }

        // Alumni showcase
        if (AlumniShowcase::count() === 0) {
            foreach ([['Bench / Suyen Corp','Alumni-Founded Brand'],['Manila Fashion Festival','Featured Designers'],['Ternate Bridal Couture','Alumni Designer'],['FDCP Philippines','Costume Designers'],['Philippine Fashion Week','Participating Designers']] as $i => [$n,$r])
                AlumniShowcase::create(['alumni_name'=>$n,'alumni_role'=>$r,'sort_order'=>$i]);
        }

        // Contact
        ContactInfo::firstOrCreate(['id' => 1], [
            'email' => 'admissions@slimsfashion.com', 'phone' => '+63 (2) 8XXX-XXXX',
            'address' => 'Metro Manila, Philippines', 'office_hours' => 'Monday – Saturday, 8:00 AM – 5:00 PM',
        ]);

        // Footer
        Footer::firstOrCreate(['id' => 1], [
            'brand_name'     => "Slim's Fashion & Arts School",
            'brand_sub'      => 'Est. 1962 · Metro Manila, Philippines',
            'brand_blurb'    => "Over six decades of nurturing Filipino talent and shaping the future of Philippine fashion through technical excellence and creative mastery.",
            'copyright_text' => '© 2019–2025 Slim\'s Fashion & Arts School. All rights reserved.',
        ]);

        // Social links
        if (SocialLink::count() === 0) {
            foreach ([['facebook','Facebook','https://facebook.com/slimsfashion',0],['instagram','Instagram','https://instagram.com/slimsfashion',1],['tiktok','TikTok','https://tiktok.com/@slimsfashion',2]] as [$p,$l,$u,$o])
                SocialLink::create(['platform'=>$p,'display_label'=>$l,'url'=>$u,'sort_order'=>$o]);
        }
    }
}
