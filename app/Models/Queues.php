<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Queues extends Model
{
    protected $table = 'queues';

    protected $fillable = [
        'event_id',
        'user_id',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
