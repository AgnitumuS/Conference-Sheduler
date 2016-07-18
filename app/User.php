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
        'name', 'email', 'password', 'settings'
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
        foreach (User::all() as $key => $value)
        {
            $settings = unserialize($value->settings);
            //ниже делаем проверку есть ли такая настройка, если есть то смотрим значение
            (array_key_exists('get_messages', $settings)) ? $settings = $settings['get_messages'] : $settings = false;
            if (isset($settings) || $settings)
            {
                $emails[] = $value->email;
                unset($settings);
            }
        }
        return $emails;
    }

    public function event()
    {
        return $this->hasMany(Event::class);
    }

    public function sendMessages()
    {
        return unserialize($this->settings)['send_messages'];
    }

    public function getMessages()
    {
        return unserialize($this->settings)['get_messages'];
    }

}
