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
        'vip_active' => 'boolean',
        'seated_active' => 'boolean',
        'capacity' => 'integer',

    ];

    protected $fillable = [
        'datetime',
        'title',
        'duration',
        'description',
        'entry_price',
        'category_id',
        'venue_id',
        'capacity',
        'image_url',
        'vip_active',
        'seated_active'
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

        // Capaciteit vol (geef voorrang aan event.capacity, anders venue.capacity)
        $limit = $this->capacity ?? ($this->venue->capacity ?? null);
        if ($limit !== null && $this->tickets()->count() >= $limit) {
            return false;
        }

        return true;
    }
}
