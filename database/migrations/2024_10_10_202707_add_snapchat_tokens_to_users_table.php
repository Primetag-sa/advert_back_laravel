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
            $table->string('snapchat_organization_id'); // Organization ID
            $table->text('snapchat_access_token')->nullable(); // توكن الوصول
            $table->text('snapchat_refresh_token')->nullable(); // توكن التحديث
            $table->text('snapchat_display_name')->nullable(); // توكن التحديث
            $table->text('snapchat_member_status')->nullable(); // توكن التحديث
            $table->text('snapchat_username')->nullable(); // توكن التحديث
            $table->timestamp('snapchat_token_expires_at')->nullable(); // تاريخ انتهاء التوكن
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'snapchat_access_token', 
                'snapchat_refresh_token', 
                'snapchat_organization_id', 
                'snapchat_token_expires_at',
                'snapchat_display_name',
                'snapchat_member_status',
                'snapchat_username',
            ]);
        });
    }
};
