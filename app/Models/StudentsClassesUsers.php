<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentsClassesUsers extends Model
{
    protected $table = 'students_classes_users';

    protected $fillable = [
        'user_id',
        'user_role_id',
    ];
}
