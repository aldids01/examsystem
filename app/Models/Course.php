<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function level():BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function exam():HasOne
    {
        return $this->hasOne(Exam::class);
    }

    public function department():BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
