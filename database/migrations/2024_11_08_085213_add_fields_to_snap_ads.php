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
        // Schema::table('snap_ads', function (Blueprint $table) {
        //     //'snapchat_account_id',
        //     // 'snapchat_campaign_id',
        //     // 'snapchat_adsquad_id_code',
        //     $table->string('snapchat_adsquad_id_code')->nullable();
        //     $table->foreignId('snapchat_account_id')->nullable()->constrained()->onDelete('cascade'); 
        //     $table->foreignId('snapchat_campaign_id')->nullable()->constrained()->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('snap_ads', function (Blueprint $table) {
        //     //
        // });
    }
};
