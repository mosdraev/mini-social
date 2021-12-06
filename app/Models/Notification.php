<?php

namespace App\Models;


use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
