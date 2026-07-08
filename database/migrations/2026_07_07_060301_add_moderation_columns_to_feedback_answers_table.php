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
        Schema::table('feedback_answers', function (Blueprint $table) {
            $table->string('moderation_status')->nullable();
            $table->integer('toxicity_score')->nullable();
            $table->text('moderation_reason')->nullable();
            $table->json('moderation_categories')->nullable();
            $table->text('original_comment')->nullable();
            $table->text('cleaned_comment')->nullable();
            $table->timestamp('moderated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedback_answers', function (Blueprint $table) {
            $table->dropColumn([
                'moderation_status',
                'toxicity_score',
                'moderation_reason',
                'moderation_categories',
                'original_comment',
                'cleaned_comment',
                'moderated_at',
            ]);
        });
    }
};
