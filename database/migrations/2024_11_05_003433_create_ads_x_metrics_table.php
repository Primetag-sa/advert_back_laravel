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
        // Schema::create('ads_x_metrics', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('account_id')->constrained('accounts');
        //     $table->string('metric_group');
        //     $table->string('placement');
        //     $table->string('granularity');
        //     $table->json('metrics_data');
        //     $table->timestamp('last_fetched_at')->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('ads_x_metrics');
    }
};
