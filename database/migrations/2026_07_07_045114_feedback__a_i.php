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
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->text('worked_well')->nullable();
            $table->text('improve')->nullable();
            $table->string('worked_status')->nullable();
            $table->string('improve_status')->nullable();
            $table->integer('worked_score')->nullable();
            $table->integer('improve_score')->nullable();
            $table->text('worked_reason')->nullable();
            $table->text('improve_reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->dropColumn([
                'worked_well',
                'improve',
                'worked_status',
                'improve_status',
                'worked_score',
                'improve_score',
                'worked_reason',
                'improve_reason',
            ]);
        });
    }
};
