<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Image;
use Carbon\Carbon;

class Post extends Model
{
    use HasFactory;

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
     * @inheritDoc
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::createFromTimeStamp(strtotime($value))->diffForHumans();
    }

    /**
     * @inheritDoc
     */
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::createFromTimeStamp(strtotime($value))->diffForHumans();
    }
}
