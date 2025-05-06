<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskUser extends Model
{
    /**
     * @var string
     */
    protected $table = 'tasks_users';

    /**
     * @return BelongsTo
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * @return BelongsTo
     */
    public function taskAnswer(): BelongsTo
    {
        return $this->belongsTo(TaskAnswer::class, 'task_answer_id');
    }
}
