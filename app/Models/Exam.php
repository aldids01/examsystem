<?php

namespace App\Models;

use Guava\Calendar\Contracts\Eventable;
use Guava\Calendar\ValueObjects\CalendarEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model implements Eventable
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

    public function toCalendarEvent(): CalendarEvent
    {
        // For eloquent models, make sure to pass the model to the constructor
        return CalendarEvent::make($this)
            ->title($this->course->code.' '.$this->course->title)
            ->start($this->created_at)
            ->end($this->updated_at);
    }
}
