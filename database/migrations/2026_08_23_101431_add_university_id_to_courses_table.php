<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('courses', 'university_id')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->foreignId('university_id')->nullable()->after('id')->constrained()->nullOnDelete();
            });
        }

        $hasData = DB::table('courses')->whereNotNull('university_id')->exists();

        if (! $hasData) {
            $courseUniversities = DB::table('courses')
                ->join('course_user', 'courses.id', '=', 'course_user.course_id')
                ->join('users', 'course_user.user_id', '=', 'users.id')
                ->whereNotNull('users.university_id')
                ->select('courses.id as course_id', 'users.university_id')
                ->distinct()
                ->orderBy('courses.id')
                ->get()
                ->keyBy('course_id');

            foreach ($courseUniversities as $courseId => $row) {
                DB::table('courses')->where('id', $courseId)->update(['university_id' => $row->university_id]);
            }

            DB::table('courses')->whereNull('university_id')->delete();
        }
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['university_id']);
            $table->dropColumn('university_id');
        });
    }
};
