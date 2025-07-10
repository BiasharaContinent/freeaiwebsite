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
        Schema::create('work_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resume_id')->constrained()->onDelete('cascade');
            $table->string('job_title');
            $table->string('company');
            $table->string('city_state')->nullable(); // e.g., "New York, NY"
            $table->date('start_date');
            $table->date('end_date')->nullable(); // Nullable if current job
            $table->boolean('is_current')->default(false);
            $table->text('responsibilities')->nullable(); // Store as JSON or Markdown for bullet points
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
        Schema::dropIfExists('work_experiences');
    }
};
