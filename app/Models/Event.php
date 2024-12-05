<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'description',
        'date_time',
        'end_event_date',
        'location',
        'ticket_price',
        'ticket_quota',
        'category_id',
        'image',
        'created_by',
        'organizer_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'event_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'event_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function hasAvailableTickets()
    {
        return $this->ticket_quota > 0;
    }

    public function decrementTicketQuota($quantity)
    {
        if ($this->ticket_quota < $quantity) {
            throw new \Exception('Not enough tickets available.');
        }

        $this->ticket_quota -= $quantity;
        $this->save();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'favorites', 'event_id', 'user_id');
    }
}
