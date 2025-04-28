<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
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

class Campaign extends Model
{
    protected $fillable = [
        'title', 'description', 'target_amount', 'current_amount', 'end_date', 'image', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}