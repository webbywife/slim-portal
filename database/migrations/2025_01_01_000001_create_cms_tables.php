<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 80)->unique();
            $table->mediumText('value')->nullable();
            $table->timestamps();
        });

        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->text('content_html');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('heroes', function (Blueprint $table) {
            $table->id();
            $table->string('eyebrow')->default('');
            $table->string('headline_main')->default('');
            $table->string('headline_em')->default('');
            $table->text('subheadline');
            $table->string('cta_primary_text', 80)->default('');
            $table->string('cta_primary_url')->default('');
            $table->string('cta_secondary_text', 80)->default('');
            $table->string('cta_secondary_url')->default('');
            $table->string('seal_year', 20)->default('');
            $table->string('seal_name', 80)->default('');
            $table->string('seal_tagline', 80)->default('');
            $table->timestamps();
        });

        Schema::create('hero_stats', function (Blueprint $table) {
            $table->id();
            $table->string('stat_value', 30);
            $table->string('stat_label', 100);
            $table->unsignedTinyInteger('sort_order')->default(0);
        });

        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->string('section_label', 80)->default('');
            $table->string('heading_main')->default('');
            $table->string('heading_em')->default('');
            $table->text('body_para1');
            $table->text('body_para2');
            $table->text('quote_text');
            $table->string('quote_cite')->default('');
            $table->string('badge_number', 20)->default('');
            $table->string('badge_text', 100)->default('');
            $table->timestamps();
        });

        Schema::create('alumni_chips', function (Blueprint $table) {
            $table->id();
            $table->string('label', 100);
            $table->unsignedTinyInteger('sort_order')->default(0);
        });

        Schema::create('online_sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_label', 80)->default('');
            $table->string('heading_line1')->default('');
            $table->string('heading_line2')->default('');
            $table->text('body_text');
            $table->string('cta_primary_text', 80)->default('');
            $table->string('cta_primary_url')->default('');
            $table->string('cta_secondary_text', 80)->default('');
            $table->string('cta_secondary_url')->default('');
            $table->string('platform_name', 80)->default('');
            $table->string('platform_tagline', 100)->default('');
            $table->string('platform_url')->default('');
            $table->timestamps();
        });

        Schema::create('online_features', function (Blueprint $table) {
            $table->id();
            $table->string('feature_title', 80);
            $table->string('feature_sub', 150);
            $table->unsignedTinyInteger('sort_order')->default(0);
        });

        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('category_tag', 80)->default('');
            $table->string('course_name', 150);
            $table->text('description');
            $table->string('duration', 60)->default('');
            $table->string('card_gradient', 150)->default('linear-gradient(135deg,#C4886B,#8B4513)');
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('enrollment_sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_label', 80)->default('');
            $table->string('heading')->default('');
            $table->text('body_text');
            $table->string('req_card_title', 150)->default('');
            $table->text('req_note');
            $table->string('cta_text', 80)->default('');
            $table->string('cta_url')->default('');
            $table->timestamps();
        });

        Schema::create('enrollment_steps', function (Blueprint $table) {
            $table->id();
            $table->string('step_title', 150);
            $table->string('step_desc');
            $table->unsignedTinyInteger('sort_order')->default(0);
        });

        Schema::create('enrollment_requirements', function (Blueprint $table) {
            $table->id();
            $table->string('requirement');
            $table->unsignedTinyInteger('sort_order')->default(0);
        });

        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('file_path')->default('');
            $table->string('caption', 200)->default('');
            $table->enum('span_type', ['normal', 'tall', 'wide'])->default('normal');
            $table->string('alt_text', 200)->default('');
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('alumni_showcases', function (Blueprint $table) {
            $table->id();
            $table->string('alumni_name', 150);
            $table->string('alumni_role', 150);
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
        });

        Schema::create('contact_infos', function (Blueprint $table) {
            $table->id();
            $table->string('email', 180)->default('');
            $table->string('phone', 60)->default('');
            $table->string('address')->default('');
            $table->string('office_hours', 150)->default('');
            $table->timestamps();
        });

        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 80);
            $table->string('last_name', 80);
            $table->string('email', 180);
            $table->string('inquiry_type', 80)->default('');
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });

        Schema::create('footers', function (Blueprint $table) {
            $table->id();
            $table->string('brand_name', 150)->default('');
            $table->string('brand_sub')->default('');
            $table->text('brand_blurb');
            $table->string('copyright_text')->default('');
            $table->timestamps();
        });

        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->string('platform', 60);
            $table->string('display_label', 60)->default('');
            $table->string('url');
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
        });
    }

    public function down(): void {
        $tables = ['social_links','footers','contact_messages','contact_infos','alumni_showcases',
            'galleries','enrollment_requirements','enrollment_steps','enrollment_sections',
            'courses','online_features','online_sections','alumni_chips','abouts',
            'hero_stats','heroes','announcements','settings'];
        foreach ($tables as $t) Schema::dropIfExists($t);
    }
};
