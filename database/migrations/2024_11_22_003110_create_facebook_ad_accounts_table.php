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
        // Schema::create('facebook_ad_accounts', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('account_id')->unique();
        //     $table->string('name')->nullable();
        //     $table->string('currency')->nullable();
        //     $table->integer('account_status')->nullable();
        //     $table->foreignId('user_id')->constrained()->onDelete('cascade');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('facebook_ad_accounts');
    }
};
