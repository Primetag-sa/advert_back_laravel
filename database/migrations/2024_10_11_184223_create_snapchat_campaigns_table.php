<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('snapchat_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('snap_id')->nullable();
            $table->string('snap_created_at')->nullable();
            $table->string('snap_name')->nullable();
            $table->bigInteger('snap_daily_budget_micro')->nullable();
            $table->string('snap_status')->nullable();
            $table->string('snap_start_time')->nullable();
            $table->string('snap_end_time')->nullable();
            $table->foreignId('snapchat_account_id')->constrained()->onDelete('cascade'); // Foreign key to snapchat_accounts
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('snapchat_campaigns');
    }
};
