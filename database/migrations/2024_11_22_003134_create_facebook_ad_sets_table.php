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
        // Schema::create('facebook_ad_sets', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('ad_set_id')->nullable();
        //     $table->string('name')->nullable();
        //     $table->string('budget')->nullable();
        //     $table->string('status')->nullable();
        //     $table->foreignId('facebook_campaign_id')->nullable()->constrained()->onDelete('cascade'); 
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('facebook_ad_sets');
    }
};
