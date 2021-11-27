<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Image;

class Post extends Model
{
    use HasFactory, HasReadableTimestampTrait;

    protected $table = 'post';

    protected $fillable = [
        'user_id',
        'content',
        'image_reference',
        'visibility',
    ];

    /**
     * Creates a post for a user and includes image reference when available.
     *
     * @return void
     */
    public static function createPost($params, Image $image = null)
    {
        $user = Auth::user();

        if ($image instanceof Image)
        {
            $data = array_merge([
                'user_id' => $user->id,
                'image_reference' => $image->path
            ], $params);
        }
        else
        {
            $data = array_merge([
                'user_id' => $user->id
            ], $params);
        }

        return Post::create($data);
    }

    /**
     * DB Relational connection from Post -> Comment model
     *
     * @return object
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * DB Relational connection from Post -> Comment model
     *
     * @return object
     */
    public function comment()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'DESC');
    }

    /**
     * DB Relational connection from Post -> Like model
     *
     * @return object
     */
    public function like()
    {
        return $this->hasMany(Like::class);
    }
}
