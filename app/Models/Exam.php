<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function course():BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function questions():HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function attempts():HasMany
    {
        return $this->hasMany(AttemptExam::class);
    }
}
