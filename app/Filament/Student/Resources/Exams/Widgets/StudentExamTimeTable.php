<?php

namespace App\Filament\Student\Resources\Exams\Widgets;


use App\Models\Exam;
use Guava\Calendar\Enums\CalendarViewType;
use Guava\Calendar\Filament\CalendarWidget;
use Guava\Calendar\ValueObjects\FetchInfo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class StudentExamTimeTable extends CalendarWidget
{
    protected string|bool|null|HtmlString $heading = 'Exam Time Table';

    protected CalendarViewType $calendarView = CalendarViewType::DayGridMonth;

    protected function getEvents(FetchInfo $info): Collection | array | Builder
    {
        // The simplest way:
        return Exam::query()
            ->whereDoesntHave('attempts')
            ->whereHas('course', function (Builder $query) {
            $query->where('department_id', auth('student')->user()->department_id);
        });

        // You probably want to query only visible events
    }
}
