<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ExamUserResult extends Model
{
	use HasFactory;

	/**
	 * @var string
	 */
	protected $table = 'exam_user_results';
	/**
	 * @var string[]
	 */
	protected $fillable = [
		'user_id',
		'module_exam_id',
		'mark'
	];
}
