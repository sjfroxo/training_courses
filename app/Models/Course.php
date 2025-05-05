<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
	use HasFactory, Sluggable;

	/**
	 * @var string
	 */
	protected $table = 'courses';
	/**
	 * @var string[]
	 */
	protected $fillable = [
		'title',
		'description',
	];

	/**
	 * @return BelongsToMany
	 */
	public function categories(): BelongsToMany
	{
		return $this->belongsToMany(Category::class, 'course_categories', 'course_id', 'category_id')
			->withTimestamps();
	}

	/**
	 * @return BelongsToMany
	 */
	public function users(): BelongsToMany
	{
		return $this->belongsToMany(User::class, 'user_courses', 'course_id', 'user_id')
			->withPivot('progress')
			->withPivot('id')
			->withTimestamps();
	}

	/**
	 * @return HasMany
	 */
	public function modules(): HasMany
	{
		return $this->hasMany(Module::class, 'course_id');
	}

	/**
	 * @return array<string,mixed>
	 */
	public function sluggable(): array
	{
		return [
			'slug' => [
				'source' => 'title',
			],
		];
	}

    public function studentsClass(): BelongsToMany
    {
        return $this->belongsToMany(StudentsClass::class, 'user_courses', 'course_id', 'user_id')
            ->withPivot('progress')
            ->withPivot('id')
            ->withTimestamps();
    }

    public function courseVisits(): HasMany
    {
        return $this->hasMany(CourseVisit::class);
    }

    public function curator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'curator_id');
    }

    /**
     * @return HasMany
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'course_id');
    }
}
