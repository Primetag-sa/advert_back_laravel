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
        Schema::create('line_items_x', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('campaigns_x'); // Associe le line item à la campagne
            $table->string('line_item_id')->unique();
            $table->string('name')->nullable();
            $table->json('placements')->nullable();
            $table->timestamp('start_time')->nullable();
            $table->bigInteger('bid_amount_local_micro')->nullable();
            $table->string('advertiser_domain')->nullable();
            $table->bigInteger('target_cpa_local_micro')->nullable();
            $table->string('goal')->nullable();
            $table->bigInteger('daily_budget_amount_local_micro')->nullable();
            $table->string('product_type')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->string('funding_instrument_id')->nullable();
            $table->string('bid_strategy')->nullable();
            $table->integer('duration_in_days')->nullable();
            $table->boolean('standard_delivery')->nullable();
            $table->bigInteger('total_budget_amount_local_micro')->nullable();
            $table->string('objective')->nullable();
            $table->string('entity_status')->nullable();
            $table->boolean('automatic_tweet_promotion')->nullable();
            $table->integer('frequency_cap')->nullable();
            $table->string('currency')->nullable();
            $table->string('pay_by')->nullable();
            $table->string('creative_source')->nullable();
            $table->boolean('deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('line_items_x');
    }
};
