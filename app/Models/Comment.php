<?php

namespace App\Models;

use App\Notifications\PostNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    use HasFactory, HasReadableTimestampTrait;

    /**
     * Database table name
     *
     * @var string
     */
    protected $table = 'comment';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'post_id',
        'content',
    ];

    protected $guarded = [];

    /**
     * Add a new comment to a related post data
     *
     * @return boolean
     */
    public function makeComment($data, Post $post)
    {
        $data['user_id'] = Auth::user()->id;
        $data['post_id'] = $post->id;

        if ($this->create($data))
        {
            $toBeNotified = $post->user;
            $notifier = Auth::user();

            if ($notifier->id !== $toBeNotified->id)
            {
                $notification = new PostNotification(PostNotification::COMMENT_NOTIFICATION, $notifier, $post);
                $toBeNotified->notify($notification);
            }
        }

        return true;
    }

    /**
     * DB Relational connection from Comment -> User model
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * DB Relational connection from Comment -> Post model
     *
     * @return object
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
