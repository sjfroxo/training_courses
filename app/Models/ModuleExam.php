<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ModuleExam extends Model
{
	use HasFactory;

	/**
	 * @var string
	 */
	protected $table = 'module_exams';
	/**
	 * @var string[]
	 */
	protected $fillable = [
		'module_id',
		'is_autochecked',
        'name',
	];

	/**
	 * @return BelongsTo
	 */
	public function module(): BelongsTo
	{
		return $this->belongsTo(Module::class);
	}

	/**
	 * @return HasMany
	 */
	public function moduleExamQuestions(): HasMany
	{
		return $this->hasMany(ModuleExamQuestion::class, 'module_exam_id');
	}

	/**
	 * @return BelongsToMany
	 */
	public function users(): BelongsToMany
	{
		return $this->belongsToMany(User::class, 'exam_user_results', 'module_exam_id',)
			->withPivot('mark')
			->withTimestamps();
	}
}
