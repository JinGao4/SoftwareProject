<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
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
}

class Donation extends Model
{
    protected $fillable = [
        'amount', 'name', 'email', 'message', 'is_anonymous', 'campaign_id', 'user_id'
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}