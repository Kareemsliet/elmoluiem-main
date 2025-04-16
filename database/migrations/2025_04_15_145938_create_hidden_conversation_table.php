<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Musonza\Chat\ConfigurationManager;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hidden_conversation', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('conversation_id')
            ->constrained(ConfigurationManager::CONVERSATIONS_TABLE)
            ->onDelete('cascade');
            $table->morphs("messageable");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hidden_conversation');
    }
};
