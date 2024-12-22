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
        // Schema::create('notifications', function (Blueprint $table) {
        //     $table->id();

        //     $table->string('title')->nullable();
        //     $table->string('message')->nullable();
        //     $table->string('value')->nullable();

        //     $table->unsignedBigInteger('sender_id')->nullable();
        //     $table->foreign('sender_id')->references('id')->on('users')->onDelete('set null');

        //     $table->unsignedBigInteger('received_id');
        //     $table->foreign('received_id')->references('id')->on('users')->onDelete('cascade');

        //     $table->timestamps();
        //     $table->softDeletes();
        // });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['system', 'agency', 'user']);
            $table->morphs('notifiable');
            $table->string('title');
            $table->text('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');

        // Schema::table('notifications', function (Blueprint $table) {
        //     $table->dropForeign(['sender_id']);
        //     $table->dropForeign(['received_id']);
        // });
        // Schema::dropIfExists('notifications');
    }
};
