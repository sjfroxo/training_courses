<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCourse extends Model
{
	use HasFactory;

	/**
	 * @var string
	 */
	protected $table = 'user_courses';
	/**
	 * @var string[]
	 */
	protected $fillable = [
		'user_id',
		'course_id',
		'progress'
	];
}
