<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class TaskAnswer extends Model
{
    protected $fillable = [
        'answer',
        'status',
        'grade'
    ];

    /**
     * @return HasOneThrough
     */
    public function task(): HasOneThrough
    {
        return $this->hasOneThrough(
            Task::class,
            TaskUser::class,
            'task_answer_id',
            'id',
            'id',
            'task_id'
        );
    }

    /**
     * @return HasOneThrough
     */
    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(
            User::class,
            TaskUser::class,
            'task_answer_id',
            'id',
            'id',
            'user_id'
        );
    }
}
