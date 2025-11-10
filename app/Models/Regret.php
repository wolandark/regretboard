<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Regret extends Model
{
    protected $fillable = ['content', 'token'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($regret) {
            if (empty($regret->token)) {
                $regret->token = bin2hex(random_bytes(32));
            }
        });
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
