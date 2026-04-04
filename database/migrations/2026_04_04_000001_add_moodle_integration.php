<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('moodle_user_id')->nullable()->after('role');
            $table->string('moodle_password')->nullable()->after('moodle_user_id');
        });

        // Enrollment applications table for public enrollment form
        Schema::create('enrollment_applications', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->unsignedBigInteger('moodle_user_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->foreign('course_id')->references('id')->on('courses')->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('enrollment_applications');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['moodle_user_id', 'moodle_password']);
        });
    }
};
