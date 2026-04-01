<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('heroes', function (Blueprint $table) {
            $table->string('bg_image')->nullable()->after('seal_tagline');
        });
        Schema::table('courses', function (Blueprint $table) {
            $table->string('course_image')->nullable()->after('card_gradient');
        });
    }
    public function down(): void {
        Schema::table('heroes', function (Blueprint $table) {
            $table->dropColumn('bg_image');
        });
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('course_image');
        });
    }
};
