<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function scopeEmailsList()
    {
        foreach (User::all() as $key=>$value) {
            $emails[] = $value->email; 
        }
        return $emails;
    }
    
    public function event()
    {
        return $this->hasMany(Event::class);
    }
}
