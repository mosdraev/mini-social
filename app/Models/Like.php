<?php

namespace App\Models;

use App\Notifications\PostNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Like extends Model
{
    use HasFactory, HasReadableTimestampTrait;

    /**
     * Database table name
     *
     * @var string
     */
    protected $table = 'like';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'post_id',
        'user_id',
    ];

    protected $guarded = [];

    /**
     * Add a new like to a related post data
     *
     * @return boolean
     */
    public function likeOrUnlike($data, Post $post)
    {
        $current_user = Auth::user();

        $likeInstance = $this->where([
            'post_id' => $post->id,
            'user_id' => $current_user->id
        ])->first();

        if ($likeInstance && $likeInstance->exists)
        {
            return $likeInstance->delete();
        }
        else
        {
            $like = $this->create([
                'post_id' => $post->id,
                'user_id' => Auth::user()->id
            ]);

            if ($like->wasRecentlyCreated)
            {
                $toBeNotified = $post->user;
                $notifier = $current_user;

                $notification = new PostNotification(PostNotification::LIKE_NOTIFICATION, $notifier, $post);
                $toBeNotified->notify($notification);

                return true;
            }
        }
    }

    /**
     * DB Relational connection from Like -> Post model
     *
     * @return object
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * DB Relational connection from Like -> User model
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
