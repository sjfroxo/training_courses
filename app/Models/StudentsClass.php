<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentsClass extends Model
{
    protected $table = 'students_classes';

    protected $fillable = [
        'name',
        'course_id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'students_classes_users', 'students_class_id', 'user_id')
            ->withPivot('user_role_id')
            ->withTimestamps();
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
