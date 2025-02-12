<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
	use HasFactory;

	/**
	 * @var string
	 */
	protected $table = 'categories';
	/**
	 * @var string[]
	 */
	protected $fillable = [
		'title',
		'description'
	];

	/**
	 * @return BelongsToMany
	 */
	public function courses(): BelongsToMany
	{
		return $this->belongsToMany(Course::class, 'course_categories', 'category_id', 'course_id')
			->withTimestamps();
	}
}
