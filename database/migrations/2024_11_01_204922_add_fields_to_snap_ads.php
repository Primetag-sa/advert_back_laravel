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
        //     $table->string('start_time')->nullable();
        //     $table->string('end_time')->nullable();
        //     $table->string('stats_conversion_purchases')->nullable();
        //     $table->string('stats_conversion_save')->nullable();
        //     $table->string('stats_conversion_start_checkout')->nullable();
        //     $table->string('stats_conversion_add_cart')->nullable();
        //     $table->string('stats_conversion_view_content')->nullable();
        //     $table->string('stats_conversion_add_billing')->nullable();
        //     $table->string('stats_conversion_sign_ups')->nullable();
        //     $table->string('stats_conversion_searches')->nullable();
        //     $table->string('stats_conversion_level_completes')->nullable();
        //     $table->string('stats_conversion_app_opens')->nullable();
        //     $table->string('stats_conversion_page_views')->nullable();
            
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