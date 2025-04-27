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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending'); // pending, completed, cancelled
            $table->date('donation_date'); 
            $table->timestamps();
        });
        
        Schema::table('donations', function (Blueprint $table) {
            $table->date('donation_date')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */

     
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
