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
     * Returns all posts with specified queries and filters or
     * returns only one record when `$id` is passed
     *
     * @return void|array
     */
    public static function getPosts(int $id = 0)
    {
        $current_user = Auth::user();
        $name_condition = "CONCAT_WS(' ', firstname, lastname) AS name";

        $query = static::addSelect([
            'likes' => Like::selectRaw('count(*) as total')
                ->whereColumn('post_id', 'post.id')
        ])
        ->addSelect([
            'likedByCurrentUser' => Like::select('user_id')
                ->whereColumn('post_id', 'post.id')
                ->where('user_id', '=', $current_user->id)
        ])
        ->addSelect([
            'byProfileName' => Profile::selectRaw($name_condition)
                ->whereColumn('user_id', 'post.user_id')
        ])
        ->with([
            'comment' => function($comment) use ($name_condition) {
                $comment->addSelect([
                    'byProfileName' => Profile::selectRaw($name_condition)
                        ->whereColumn('user_id', 'comment.user_id')
                ]);
            },
        ]);

        // Query specific post
        if (is_numeric($id) && $id > 0)
        {
            return $query->where('id', $id)->first()->toArray();
        }

        // Paginate through all posts
        return $query->orderBy('id', 'DESC')->cursorPaginate(10)->toArray();
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
