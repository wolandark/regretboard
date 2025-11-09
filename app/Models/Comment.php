<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = ['regret_id', 'content'];

    public function regret(): BelongsTo
    {
        return $this->belongsTo(Regret::class);
    }
}
