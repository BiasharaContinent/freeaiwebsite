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
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g., "Classic Professional", "Modern Minimalist"
            $table->string('description')->nullable();
            $table->enum('type', ['ats', 'styled'])->default('styled'); // To filter templates by type
            $table->string('preview_image_path')->nullable(); // Path to a thumbnail image
            $table->string('view_name')->unique(); // e.g., 'templates.classic_professional' Blade view for rendering
            // Store design specifications as JSON or separate fields
            $table->json('font_specs')->nullable(); // e.g., {"body": "Arial", "heading": "Helvetica"}
            $table->json('color_specs')->nullable(); // e.g., {"primary": "#000000", "accent": "#CCCCCC"}
            $table->json('layout_specs_json')->nullable(); // For more complex layout rules if needed
            $table->boolean('is_active')->default(true); // Admin can deactivate templates
            $table->timestamps();
        });

        // Add template_id to resumes table (if not already added, though it's commented out in Resume model)
        // It's better to do this in a separate migration if resumes table is already created and has data.
        // For a fresh setup, it could be here or in the resumes migration.
        // Let's assume we'll add it via a new migration to be safe.
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('templates');
    }
};
