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
        Schema::table('users', callback: function (Blueprint $table) {
            $table->string('facebook_name')->nullable();
            $table->string('facebook_email')->nullable();
            $table->string('facebook_avatar')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('facebook_expires_in')->nullable();
            $table->text('facebook_token')->nullable();
            $table->text('facebook_refresh_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
