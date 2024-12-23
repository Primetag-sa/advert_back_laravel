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
        // Schema::create('accounts_x', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('account_id')->unique();
        //     $table->string('name')->nullable();
        //     $table->string('business_name')->nullable();
        //     $table->string('timezone')->nullable();
        //     $table->timestamp('timezone_switch_at')->nullable();
        //     $table->string('business_id')->nullable();
        //     $table->string('approval_status')->nullable();
        //     $table->boolean('deleted')->default(false);
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('accounts_x');
    }
};