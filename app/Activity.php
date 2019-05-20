<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Activity extends Model
{
    protected $guarded = [];

    protected $casts = [
        'changes' => 'array',
    ];

    public function subject()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}