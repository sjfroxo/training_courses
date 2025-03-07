<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
	use HasFactory, Sluggable;

	/**
	 * @var string
	 */
	protected $table = 'modules';
	/**
	 * @var string[]
	 */
	protected $fillable = [
		'title',
		'course_id',
		'content'
	];

	/**
	 * @return BelongsTo
	 */
	public function course(): BelongsTo
	{
		return $this->belongsTo(Course::class, 'course_id');
	}

	/**
	 * @return HasMany
	 */
	public function moduleComments(): HasMany
	{
		return $this->hasMany(ModuleComment::class, 'module_id');
	}

	/**
	 * @return HasMany
	 */
	public function moduleExams(): HasMany
	{
		return $this->hasMany(ModuleExam::class, 'module_id');
	}

	public function sluggable(): array
	{
		return [
			'slug' => [
				'source' => 'title',
			],
		];
	}
}
