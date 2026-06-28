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
            $table->tinyInteger('practical')->unsigned()->default(0)->after('fairness');
            $table->tinyInteger('organization')->unsigned()->default(0)->after('practical');
            $table->tinyInteger('overall_rating')->unsigned()->default(0)->after('organization');
            $table->text('what_worked_well')->nullable()->after('comments');
            $table->text('what_could_improve')->nullable()->after('what_worked_well');
            $table->string('recommendation')->nullable()->after('what_could_improve'); // yes_definitely, neutral, not_really
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->dropColumn(['practical', 'organization', 'overall_rating', 'what_worked_well', 'what_could_improve', 'recommendation']);
        });
    }
};
