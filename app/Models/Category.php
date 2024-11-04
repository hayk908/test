<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $table = 'category';
    protected $fillable = [
        'user_id',
        'name'
    ];

    public $timestamps = FALSE;

    public function user(): belongsToMany
    {
        return $this->belongsToMany(User::class, 'users_category');
    }
}
