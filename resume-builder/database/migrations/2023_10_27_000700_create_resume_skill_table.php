<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resume_skill', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resume_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');
            // Add any additional pivot table columns if needed, e.g., proficiency level for a skill on a specific resume
            // $table->enum('proficiency', ['beginner', 'intermediate', 'advanced', 'expert'])->nullable();
            $table->timestamps();

            $table->unique(['resume_id', 'skill_id']); // Prevent duplicate skill entries per resume
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resume_skill');
    }
};
