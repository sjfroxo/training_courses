<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuestionType extends Model
{
	use HasFactory;

	/**
	 * @var string
	 */
	protected $table = 'question_types';
	/**
	 * @var string[]
	 */
	protected $fillable = [
		'title'
	];

	/**
	 * @return HasMany
	 */
	public function moduleExamQuestion(): HasMany
	{
		return $this->hasMany(ModuleExamQuestion::class);
	}
}
