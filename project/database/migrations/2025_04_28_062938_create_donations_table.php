<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('donations', function (Blueprint $table) {
        $table->id();
        $table->decimal('amount', 10, 2);
        $table->string('name');
        $table->string('email');
        $table->text('message')->nullable();
        $table->boolean('is_anonymous')->default(false);
        $table->foreignId('campaign_id')->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
        $table->timestamps();
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
