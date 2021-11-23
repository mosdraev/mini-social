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

    protected $guarded = [];

    /**
     * Function to update Profile and User models
     *
     * @return object|boolean
     */
    public function modify($user_id, $data)
    {
        $user = User::where('id', $user_id)->first();
        $profile = $this->where('user_id', $user_id)->first();

        $user_data = ['email' => $data['email']];
        unset($data['email']);

        $profile->attributes = $data;
        $user->attributes = $user_data;

        return ($profile->update() && $user->update()) ? true : false;
    }

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
