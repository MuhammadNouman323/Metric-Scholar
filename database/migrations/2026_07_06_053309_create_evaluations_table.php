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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('semester'); // Treating as string as requested or can be foreign if needed
            $table->string('evaluation_type');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status')->default('draft');
            $table->boolean('is_anonymous')->default(true);
            $table->boolean('allow_faculty_response')->default(false);
            $table->boolean('send_reminder')->default(true);
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
