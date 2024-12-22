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
        // Schema::create('visitor_events', function (Blueprint $table) {
        //     $table->id();
            
        //     $table->foreignId('visitor_id')->nullable()->constrained('visitors'); // Foreign key to visitors table
        //     $table->string('url'); // URL of the event
        //     $table->string('title'); // Title of the page
        //     $table->string('event_type'); // Type of event (e.g., page view, click)
        //     $table->decimal('time_spent', 8, 2)->nullable(); // Time spent on page
        //     $table->timestamps(); // Created and updated timestamps
        //     $table->integer('click_count')->nullable(); // Click count
            
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('visitor_events');
    }
};