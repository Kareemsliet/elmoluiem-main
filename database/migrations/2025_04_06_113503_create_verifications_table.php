<?php

use App\Enums\VerificationTypeEnums;
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
        Schema::create('verifications', function (Blueprint $table) {
            $table->id();
            $table->string("code");
            $table->timestamp("expired_at")->nullable();
            $table->morphs("verifiable");
            $table->integer("uses")->default(0);
            $table->string("type")->default(VerificationTypeEnums::Email->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verifications');
    }
};
