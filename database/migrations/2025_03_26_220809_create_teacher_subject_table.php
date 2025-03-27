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
        Schema::create('teacher_subject', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("teacher_id")->unsigned();
            $table->foreign("teacher_id")->references("id")->on("teachers")->onDelete("cascade")->onUpdate("cascade");
            $table->bigInteger("subject_id")->unsigned();
            $table->foreign("subject_id")->references("id")->on("subjects")->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_subject');
    }
};
