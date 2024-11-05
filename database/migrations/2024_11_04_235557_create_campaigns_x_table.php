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
        Schema::create('campaigns_x', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained('accounts_x'); // Associe la campagne au compte
            $table->string('campaign_id')->unique();
            $table->string('name')->nullable();
            $table->string('budget_optimization')->nullable();
            $table->json('reasons_not_servable')->nullable();
            $table->boolean('servable')->default(false);
            $table->string('purchase_order_number')->nullable();
            $table->string('effective_status')->nullable();
            $table->bigInteger('daily_budget_amount_local_micro')->nullable();
            $table->string('funding_instrument_id')->nullable();
            $table->integer('duration_in_days')->nullable();
            $table->boolean('standard_delivery')->nullable();
            $table->bigInteger('total_budget_amount_local_micro')->nullable();
            $table->string('entity_status')->nullable();
            $table->integer('frequency_cap')->nullable();
            $table->string('currency')->nullable();
            $table->boolean('deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns_x');
    }
};
