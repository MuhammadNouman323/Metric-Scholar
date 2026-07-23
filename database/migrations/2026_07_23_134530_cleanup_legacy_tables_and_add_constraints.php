<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop legacy singular 'feedback' table (no longer used; replaced by 'feedbacks')
        if (Schema::hasTable('feedback')) {
            Schema::dropIfExists('feedback');
        }

        // Drop legacy 'feedback_access' table (not used by any controller/service)
        if (Schema::hasTable('feedback_access')) {
            Schema::dropIfExists('feedback_access');
        }

        // Add composite unique constraint to course_user pivot to prevent duplicate assignments
        Schema::table('course_user', function (Blueprint $table) {
            $dropped = false;
            // Drop the auto-increment id primary key first if needed
            // $table->dropPrimary(); // Only if primary is on 'id'
            $table->unique(['course_id', 'user_id', 'term'], 'course_user_unique');
        });

        // Add composite unique constraint to evaluation_courses pivot
        Schema::table('evaluation_courses', function (Blueprint $table) {
            $table->unique(['evaluation_id', 'course_id', 'faculty_id'], 'evaluation_courses_unique');
        });

        // Add composite unique constraint to evaluation_faculty pivot
        Schema::table('evaluation_faculty', function (Blueprint $table) {
            $table->unique(['evaluation_id', 'faculty_id'], 'evaluation_faculty_unique');
        });
    }

    public function down(): void
    {
        Schema::table('evaluation_faculty', function (Blueprint $table) {
            $table->dropUnique('evaluation_faculty_unique');
        });

        Schema::table('evaluation_courses', function (Blueprint $table) {
            $table->dropUnique('evaluation_courses_unique');
        });

        Schema::table('course_user', function (Blueprint $table) {
            $table->dropUnique('course_user_unique');
        });
    }
};
