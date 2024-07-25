<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'created_by',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'channel_user', 'channel_id', 'user_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected static function booted()
    {
        static::saving(function (Channel $channel) {
            $channel->created_by = $channel->created_by ?: auth()->id();
        });
    }
}
