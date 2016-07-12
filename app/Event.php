<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    protected $guarded = ['created_at', 'updated_at'];
    protected $dates = ['created_at', 'updated_at', 'start', 'stop'];

    public function getStartAttribute($value)
    {
        return Carbon::parse($value)->format('d.m.Y H:i');
    }
    public function getStopAttribute($value)
    {
        return Carbon::parse($value)->format('d.m.Y H:i');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

}
