<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'count',
    ];

    protected $guarded = [];

    /**
     * DB Relational connection from Like -> Post model
     *
     * @return object
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
