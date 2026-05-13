<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    //protected $primaryKey = 'event_id';

    protected $casts = [
        'datetime' => 'datetime',
        'registration_closed' => 'boolean',

    ];

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

    public function canRegister()
{
    // Aanmelding handmatig gesloten
    if ($this->registration_closed) {
        return false;
    }

    // Event al begonnen
    if (now()->isAfter($this->datetime)) {
        return false;
    }

    // Venue vol
    if ($this->tickets()->count() >= $this->venue->capacity) {
        return false;
    }

    return true;
}
}
