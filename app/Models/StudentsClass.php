<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentsClass extends Model
{
    protected $table = 'students_classes';

    protected $fillable = [
        'name',
        'course_id',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'students_classes_users', 'students_class_id', 'user_id')
            ->withPivot('id')
            ->withTimestamps();
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'course_id');
    }
}
