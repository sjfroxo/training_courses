<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ModuleExamQuestion extends Model
{
	use HasFactory;

	/**
	 * @var string
	 */
	protected $table = 'module_exam_questions';
	/**
	 * @var string[]
	 */
	protected $fillable = [
		'text',
		'module_exam_id',
		'question_type_id'
	];

	/**
	 * @return BelongsTo
	 */
	public function moduleExam(): BelongsTo
	{
		return $this->belongsTo(ModuleExam::class);
	}

	/**
	 * @return HasMany
	 */
	public function moduleExamAnswers(): HasMany
	{
		return $this->hasMany(ModuleExamAnswer::class);
	}

	/**
	 * @return BelongsToMany
	 * Пользователи которые ответили на вопросы
	 */
	public function users(): BelongsToMany
	{
		return $this->belongsToMany(User::class, 'module_exam_user_responses', 'module_exam_question_id', 'user_id')
			->withPivot('text', 'module_exam_answer_id')
			->withTimestamps();
	}

	/**
	 * @return BelongsTo
	 */
	public function questionType(): BelongsTo
	{
		return $this->belongsTo(QuestionType::class);
	}
}
