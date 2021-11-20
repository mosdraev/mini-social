<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profile';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'firstname',
        'lastname',
        'mobile_number'
    ];

    /**
     * DB Relational connection from Profile -> User model
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo('user');
    }
}
