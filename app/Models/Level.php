<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function courses():HasMany
    {
        return $this->hasMany(Course::class);
    }
}
