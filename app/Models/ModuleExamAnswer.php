<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ModuleExamAnswer extends Model
{
	use HasFactory;

	/**
	 * @var string
	 */
	protected $table = 'module_exam_answers';
	/**
	 * @var string[]
	 */
	protected $fillable = [
		'value',
		'module_exam_question_id',
        'module_exam_user_response_id',
		'is_correct',
        'module_exam_id',
	];

	/**
	 * @return BelongsTo
	 */
	public function moduleExamQuestion(): BelongsTo
	{
		return $this->belongsTo(ModuleExamQuestion::class);
	}

	/**
	 * @return BelongsToMany
	 * Ответы пользователей на тесты
	 */
	public function users(): BelongsToMany
	{
		return $this->belongsToMany(User::class, 'module_exam_user_responses', 'module_exam_answer_id', 'user_id')
			->withPivot('question_id')
			->withTimestamps();
	}

    public function moduleExamUserResponse(): HasMany
    {
        return $this->hasMany(ModuleExamUserResponse::class, 'module_exam_answer_id');
    }

}
