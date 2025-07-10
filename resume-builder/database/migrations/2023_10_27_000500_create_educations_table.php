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
        Schema::create('educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resume_id')->constrained()->onDelete('cascade');
            $table->string('degree'); // e.g., "Bachelor of Science"
            $table->string('institution'); // e.g., "University of Example"
            $table->string('major')->nullable(); // e.g., "Computer Science"
            $table->string('city_state')->nullable(); // e.g., "Boston, MA"
            $table->date('graduation_start_date')->nullable();
            $table->date('graduation_end_date')->nullable(); // Or expected graduation date
            $table->text('details')->nullable(); // e.g., GPA, honors, relevant coursework (store as JSON or Markdown)
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
        Schema::dropIfExists('educations');
    }
};
