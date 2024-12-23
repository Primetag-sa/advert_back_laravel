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
        // Schema::create('snapchat_accounts', function (Blueprint $table) {
        //     $table->id();
        //     $table->string(column: 'snap_adaccount_id')->nullable();
        //     $table->string('snap_adaccount_created_at')->nullable();
        //     $table->string('snap_adaccount_name')->nullable();
        //     $table->string('snap_adaccount_type')->nullable();
        //     $table->string('snap_adaccount_status')->nullable();
        //     $table->string('snap_adaccount_organization_id')->nullable();
        //     $table->string('snap_adaccount_currency')->nullable();
        //     $table->string('snap_adaccount_timezone')->nullable();
        //     $table->string('snap_adaccount_advertiser_organization_id')->nullable();
        //     $table->string('snap_adaccount_advertiser_billing_type')->nullable();
        //     $table->boolean('snap_adaccount_agency_representing_client')->nullable();
        //     $table->boolean('snap_adaccount_client_paying_invoices')->nullable();
        //     $table->foreignId('user_id')->constrained()->onDelete('cascade'); // foreign key for user table
        //     $table->timestamps(); // created_at and updated_at
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('snapchat_accounts');
    }
};