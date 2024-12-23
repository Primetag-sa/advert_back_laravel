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
        // Schema::create('facebook_ads', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('ad_id')->nullable();
        //     $table->string('name')->nullable();
        //     $table->string('status')->nullable();
        //     $table->string('creative')->nullable();
        //     $table->foreignId('facebook_ad_account_id')->nullable()->constrained()->onDelete('cascade'); 
        //     $table->foreignId('facebook_campaign_id')->nullable()->constrained()->onDelete('cascade'); 
        //     $table->foreignId('facebook_ad_set_id')->nullable()->constrained()->onDelete('cascade'); 
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('facebook_ads');
    }
};
