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
        Schema::create('promoted_tweets_x', function (Blueprint $table) {
            $table->id();
            $table->foreignId('line_item_id')->constrained('line_items_x'); // Associe le tweet promu au line item
            $table->string('tweet_id')->unique();
            $table->string('entity_status')->nullable();
            $table->string('approval_status')->nullable();
            $table->boolean('deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promoted_tweets_x');
    }
};
