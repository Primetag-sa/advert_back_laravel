<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('snap_ads', function (Blueprint $table) {
            $table->id();
            $table->string('snap_id')->nullable();
            $table->string('snap_created_at')->nullable();
            $table->string('snap_name')->nullable();
            $table->string('snap_creative_id')->nullable();
            $table->string('snap_status')->nullable();
            $table->string('snap_type')->nullable();
            //
            $table->string('stats_id')->nullable();
            $table->string('stats_type')->nullable();
            $table->string('stats_granularity')->nullable();
            $table->string('stats_impressions')->nullable();
            $table->string('stats_swipes')->nullable();
            $table->string('stats_spend')->nullable();
            $table->string('stats_quartile_1')->nullable();
            $table->string('stats_quartile_2')->nullable();
            $table->string('stats_quartile_3')->nullable();
            $table->string('stats_view_completion')->nullable();
            $table->string('stats_screen_time_millis')->nullable();

            $table->foreignId('snapchat_adsquad_id')->constrained('snapchat_adsquads')->onDelete('cascade'); // Foreign key to snapchat_adsquads table
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('snap_ads');
    }
};
