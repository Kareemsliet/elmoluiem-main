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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->foreignId("subject_id")->constrained('subjects')->onDelete('restrict');
            $table->foreignId("education_level_id")->constrained('education_levels')->onDelete('restrict');
            $table->string("academic_year")->nullable();
            $table->string("start_time")->nullable();
            $table->string("end_time")->nullable();
            $table->foreignId("teacher_id")->constrained('teachers')->onDelete('cascade');
            $table->integer("time_limit")->default(0)->comment('Time limit in minutes');
            $table->timestamp("date")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
