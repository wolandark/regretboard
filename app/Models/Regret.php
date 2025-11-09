<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Regret extends Model
{
    protected $fillable = ['content'];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
