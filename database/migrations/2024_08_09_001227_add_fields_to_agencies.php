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
        // Schema::table('agencies', function (Blueprint $table) {
        //     $table->string('address')->nullable();
        //     $table->text('permissions')->nullable();
        //     $table->string('facebook_url')->nullable();
        //     $table->string('tiktok_url')->nullable();
        //     $table->string('snapchat_url')->nullable();
        //     $table->string('x_url')->nullable();
        //     $table->string('instagram_url')->nullable();
        //     $table->unsignedBigInteger('pack_id')->nullable();
        //     $table->foreign('pack_id')->references('id')->on('packs')->onDelete('cascade');//restrict
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('agencies', function (Blueprint $table) {
        //     Schema::table('agencies', function (Blueprint $table) {
        //         $table->dropColumn([
        //             'address',
        //             'permissions',
        //             'facebook_url',
        //             'tiktok_url',
        //             'snapchat_url',
        //             'x_url',
        //             'instagram_url',
        //             'pack_id'
        //         ]);
        //     });
        // });
    }
};