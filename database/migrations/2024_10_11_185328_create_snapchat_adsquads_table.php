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
        Schema::create('snapchat_adsquads', function (Blueprint $table) {
            $table->id();
            $table->string('snap_id')->nullable();
            $table->string('snap_created_at')->nullable();
            $table->string('snap_name')->nullable();
            $table->string('snap_status')->nullable();
            $table->string('snap_type')->nullable();
            $table->string('snap_billing_event')->nullable();
            $table->boolean('snap_auto_bid')->nullable();
            $table->bigInteger('snap_target_bid')->nullable();
            $table->string('snap_bid_strategy')->nullable();
            $table->bigInteger('snap_daily_budget_micro')->nullable();
            $table->string('snap_start_time')->nullable();
            $table->string('snap_optimization_goal')->nullable();
            $table->foreignId('snapchat_campaign_id')->constrained()->onDelete('cascade'); // Foreign key to snapchat_campaigns table
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
        Schema::dropIfExists('snapchat_adsquads');
    }
};
