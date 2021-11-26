<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    /**
     * Database table name
     *
     * @var string
     */
    protected $table = 'image';

    /**
     * @inheritdoc
     */
    public function getRouteKeyName()
    {
        return 'user_id';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'type',
        'path',
    ];

    protected $guarded = [];

    /**
     * DB Relational connection from Image -> User model
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo('user');
    }
}
