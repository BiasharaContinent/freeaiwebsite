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
        Schema::table('resumes', function (Blueprint $table) {
            // Add after 'user_id' or any other suitable column
            $table->foreignId('template_id')->nullable()->after('user_id')->constrained('templates')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resumes', function (Blueprint $table) {
            // It's good practice to drop foreign keys by name if known, or by column array
            // $table->dropForeign(['template_id']);
            // For simplicity, if foreign key constraint name is default like 'resumes_template_id_foreign'
            // Dropping column will also drop the key if your DB supports it.
            // However, to be explicit:
            if (DB::getDriverName() !== 'sqlite') { // SQLite has limitations with dropping foreign keys
                 $table->dropForeign(['template_id']);
            }
            $table->dropColumn('template_id');
        });
    }
};
