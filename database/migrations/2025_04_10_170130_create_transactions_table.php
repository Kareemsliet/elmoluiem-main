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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->double("total")->default(0.0);
            $table->bigInteger("teacher_id")->unsigned();
            $table->foreign("teacher_id")->references("id")->on("teachers")->onDelete("cascade")->onUpdate("cascade");
            $table->decimal("commission")->default(0.10);
            $table->decimal("teacher_amount")->default(0.0);
            $table->decimal("commission_amount")->default(0.0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
