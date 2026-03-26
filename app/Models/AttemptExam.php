<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttemptExam extends Model
{
    protected $guarded = [];
    protected $casts = [
        'started_at'   => 'datetime',
        'completed_at' => 'datetime',
        'expires_at'   => 'datetime',
        'percentage'   => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function exam():BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function student():BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isCompleted(): bool
    {
        return ! is_null($this->completed_at);
    }

    public function isExpired(): bool
    {
        return $this->expires_at && now()->greaterThan($this->expires_at);
    }
}
