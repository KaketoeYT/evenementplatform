<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    //protected $primaryKey = 'event_id';

    protected $fillable = [
        'datetime',
        'title',
        'duration',
        'description',
        'entry_price',
        'category_id',
        'venue_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function tickets() 
    {
        return $this->hasMany(Ticket::class);
    }
}
