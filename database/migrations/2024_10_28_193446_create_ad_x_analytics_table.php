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
        Schema::create('ad_x_analytics', function (Blueprint $table) {
            $table->id();
            $table->string('data_type');
            $table->string('account_id');
            $table->string('ad_id');  // exemple: 'dvcz7'
            $table->integer('time_series_length');
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->string('granularity');
            $table->json('data_analytics');  // Stocke toute la structure de données
            $table->timestamps();
            $table->softDeletes(); // Ajoute une colonne pour la suppression en douceur
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_x_analytics');
    }
};
