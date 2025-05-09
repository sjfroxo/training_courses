<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Task extends Model
{
    protected $fillable = [
        'name',
        'description',
        'deadline',
        'course_id'
    ];

    /**
     * @return HasOneThrough
     */
    public function taskAnswer(): HasOneThrough
    {
        return $this->hasOneThrough(
            TaskAnswer::class,
            TaskUser::class,
            'task_id',
            'id',
            'id',
            'task_answer_id'
        );
    }

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'tasks_users', 'task_id', 'user_id');
    }

    /**
     * @return HasOne
     */
    public function course(): HasOne
    {
        return $this->hasOne(Course::class, 'id', 'course_id');
    }

    /**
     * @return string
     */
    public function getDeadlineFormattedAttribute(): string
    {
        $months = [
            1 => 'янв.', 2 => 'февр.', 3 => 'март', 4 => 'апр.', 5 => 'мая', 6 => 'июня',
            7 => 'июля', 8 => 'авг.', 9 => 'сент.', 10 => 'окт.', 11 => 'нояб.', 12 => 'дек.'
        ];

        $date = Carbon::parse($this->attributes['deadline']);

        $day = $date->day;
        $month = $months[$date->month];
        $year = $date->year;

        return "{$day} {$month} {$year} г.";
    }
}
