<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Function to create a User along with their profile data
     *
     * @return User
     */
    public static function register($params)
    {
        $user = static::create([
            'email' => $params['email'],
            'password' => Hash::make($params['password'])
        ]);

        if ($user->wasRecentlyCreated)
        {
            Profile::create([
                'user_id' => $user->id,
                'firstname' => $params['firstname'],
                'lastname' => $params['lastname'],
            ]);
        }

        return $user;
    }

    /**
     * DB Relational connection from User -> Profile model
     *
     * @return object
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * DB Relational connection from User -> Image model
     *
     * @return object
     */
    public function image()
    {
        return $this->hasMany(Image::class);
    }

    /**
     * DB Relational connection from User -> Post model
     *
     * @return object
     */
    public function post()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * DB Relational connection from User -> Comment model
     *
     * @return object
     */
    public function comment()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    /**
     * DB Relational connection from User -> Comment model
     *
     * @return object
     */
    public function like()
    {
        return $this->hasMany(User::class, 'user_id');
    }
}
