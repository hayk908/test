<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'bio',
        'avatar'
    ];

    protected $table = 'profiles';

    /**
     * @return BelongsTo<User, Profile>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<User, Profile>
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
