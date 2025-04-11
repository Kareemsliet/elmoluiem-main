<?php

use App\Enums\PaymentStatusEnums;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payouts', function (Blueprint $table) {
            $table->id();
            $table->decimal("amount")->default(0.0);
            $table->bigInteger("teacher_id")->unsigned();
            $table->foreign("teacher_id")->references("id")->on("teachers")->onDelete("cascade")->onUpdate("cascade");
            $table->string("status")->default(PaymentStatusEnums::PENDING->value);
            $table->string("transaction_id")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payouts');
    }
};
