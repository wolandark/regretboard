<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = ['regret_id', 'content', 'token'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($comment) {
            if (empty($comment->token)) {
                $comment->token = bin2hex(random_bytes(32));
            }
        });
    }

    public function regret(): BelongsTo
    {
        return $this->belongsTo(Regret::class);
    }
}
