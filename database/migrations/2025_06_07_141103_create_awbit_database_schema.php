<?php
// KODE FINAL DAN LENGKAP
// database/migrations/xxxx_xx_xx_xxxxxx_create_awbit_database_schema.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // --- 1. FONDASI OTENTIKASI ---
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->string('nim_nidn')->unique()->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // --- 2. TABEL STANDAR LARAVEL (CACHE & JOBS) ---
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        // --- 3. STRUKTUR INTI AKADEMIK ---
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('course_code', 50)->unique()->nullable();
            $table->foreignId('lecturer_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('title');
            $table->unsignedInteger('week_number')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->string('title');
            $table->enum('type', ['book', 'ppt', 'video', 'file']);
            $table->text('content')->nullable();
            $table->string('file_path', 2048)->nullable();
            $table->unsignedInteger('points_reward')->default(0);
            $table->timestamps();
        });

        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['multiple_choice', 'essay', 'file_upload'])->default('multiple_choice');
            $table->dateTime('due_date')->nullable();
            $table->unsignedInteger('points_possible')->default(100);
            $table->timestamps();
        });

        // --- 4. TABEL PENGHUBUNG & PROGRESS ---
        Schema::create('course_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->timestamp('enrolled_at')->useCurrent();
            $table->timestamps();
            $table->unique(['student_id', 'course_id']);
        });

        Schema::create('student_material_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('material_id')->constrained('materials')->onDelete('cascade');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->unique(['student_id', 'material_id']);
        });

        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('submitted_at')->useCurrent();
            $table->string('file_path', 2048)->nullable();
            $table->decimal('grade', 5, 2)->nullable();
            $table->text('feedback')->nullable();
            $table->foreignId('graded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('graded_at')->nullable();
            $table->timestamps();
            $table->unique(['assignment_id', 'student_id']);
        });

        // --- 5. DETAIL KUIS / TUGAS ---
        Schema::create('assignment_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->text('question_text');
            $table->enum('question_type', ['multiple_choice', 'essay'])->default('multiple_choice');
            $table->timestamps();
        });

        Schema::create('assignment_question_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_question_id')->constrained('assignment_questions')->onDelete('cascade');
            $table->string('option_text');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });

        Schema::create('assignment_submission_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_submission_id')->constrained('assignment_submissions')->onDelete('cascade');
            $table->foreignId('assignment_question_id')->constrained('assignment_questions')->onDelete('cascade');
            $table->foreignId('assignment_question_option_id')->nullable();
            $table->foreign('assignment_question_option_id', 'asa_aqo_id_foreign')->references('id')->on('assignment_question_options')->onDelete('set null');
            $table->text('answer_text')->nullable();
            $table->boolean('is_correct')->nullable();
            $table->unsignedInteger('points_awarded')->default(0);
            $table->timestamps();
        });

        // --- 6. FITUR GAMIFIKASI ---
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->string('icon_path', 2048)->nullable();
            $table->unsignedInteger('required_points')->nullable();
            $table->enum('type', ['points', 'activity', 'manual'])->default('points');
            $table->timestamps();
        });

        Schema::create('user_badges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('badge_id')->constrained('badges')->onDelete('cascade');
            $table->timestamp('awarded_at')->useCurrent();
            $table->timestamps();
            $table->unique(['user_id', 'badge_id']);
        });

        Schema::create('user_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('set null');
            $table->integer('points')->default(0);
            $table->string('reason')->nullable();
            $table->morphs('related');
            $table->timestamps();
        });

        // --- 7. FITUR FORUM & LAINNYA ---
        Schema::create('forums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('forum_threads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('forum_id')->constrained('forums')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('content');
            $table->timestamps();
        });

        Schema::create('forum_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('forum_thread_id')->constrained('forum_threads')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('content');
            $table->foreignId('parent_post_id')->nullable()->constrained('forum_posts')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('action');
            $table->text('description')->nullable();
            $table->ipAddress()->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('forum_posts');
        Schema::dropIfExists('forum_threads');
        Schema::dropIfExists('forums');
        Schema::dropIfExists('user_points');
        Schema::dropIfExists('user_badges');
        Schema::dropIfExists('badges');
        Schema::dropIfExists('assignment_submission_answers');
        Schema::dropIfExists('assignment_question_options');
        Schema::dropIfExists('assignment_questions');
        Schema::dropIfExists('assignment_submissions');
        Schema::dropIfExists('student_material_progress');
        Schema::dropIfExists('course_enrollments');
        Schema::dropIfExists('materials');
        Schema::dropIfExists('assignments');
        Schema::dropIfExists('sections');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
    }
};