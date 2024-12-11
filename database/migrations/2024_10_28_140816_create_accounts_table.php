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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id(); // ID auto-incrémenté par Laravel
            $table->string('name');
            $table->string('business_name')->nullable();
            $table->string('timezone');
            $table->timestamp('timezone_switch_at')->nullable();
            $table->string('account_id')->unique(); // Le champ ID spécifique du compte
            $table->string('salt')->nullable();
            $table->string('approval_status');
            $table->boolean('deleted')->default(false);
            $table->timestamps();
            $table->softDeletes(); // Ajoute une colonne pour la suppression en douceur
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
