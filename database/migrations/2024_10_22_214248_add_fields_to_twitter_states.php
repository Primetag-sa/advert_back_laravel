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
        Schema::table('twitter_states', function (Blueprint $table) {
            $table->string('access_token')->nullable();  // Ajouter cette colonne
            $table->dropColumn('session_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('twitter_states', function (Blueprint $table) {
            //
        });
    }
};
