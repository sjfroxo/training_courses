<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
	use HasFactory;

	/**
	 * @var string
	 */
	protected $table = 'course_categories';
	/**
	 * @var string[]
	 */
	protected $fillable = [
		'category_id',
		'course_id'
	];
}
