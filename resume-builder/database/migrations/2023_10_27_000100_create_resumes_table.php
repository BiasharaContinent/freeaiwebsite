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
        Schema::create('resumes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // $table->foreignId('template_id')->nullable()->constrained()->onDelete('set null'); // We'll create templates table later
            $table->string('title')->default('My Resume'); // A user might have multiple resumes
            $table->enum('format_type', ['ats', 'styled'])->default('styled');
            $table->boolean('is_draft')->default(true);
            $table->string('public_link_slug')->nullable()->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resumes');
    }
};
