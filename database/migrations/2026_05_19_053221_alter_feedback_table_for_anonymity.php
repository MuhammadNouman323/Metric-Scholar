<?php

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
        Schema::table('feedback', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropUnique(['user_id', 'course_id']);
            $table->dropColumn('user_id');

            $table->string('anonymous_token')->unique()->after('id');
            $table->foreignId('faculty_id')->nullable()->constrained('users')->nullOnDelete()->after('course_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->dropForeign(['faculty_id']);
            $table->dropColumn('faculty_id');
            $table->dropColumn('anonymous_token');

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unique(['user_id', 'course_id']);
        });
    }
};
