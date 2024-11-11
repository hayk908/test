<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content'
    ];

    public $table = 'posts';

    /**
     * Get the user that owns the post.
     *
     * @return BelongsTo<User, Post>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
