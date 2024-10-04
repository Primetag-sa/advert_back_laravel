<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSnapchatAdsTable extends Migration
{
    public function up()
    {
        Schema::create('snapchat_ads', function (Blueprint $table) {
            $table->id();
            $table->string('ad_name'); // or 'ad_id' if you prefer
            $table->integer('impressions');
            $table->integer('clicks')->nullable();
            $table->float('cost')->nullable();
            $table->float('revenue')->nullable();
            $table->string('promo_code')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('snapchat_ads');
    }
}
