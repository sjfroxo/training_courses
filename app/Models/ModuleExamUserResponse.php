<?php

namespace App\Models;

use App\Http\Requests\ModuleExamAnswerRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ModuleExamUserResponse extends Model
{
	use HasFactory;

	/**
	 * @var string
	 */
	protected $table = 'module_exam_user_responses';
    /**
     * @var string[]
     */
    protected $fillable = [
        'module_exam_question_id',
        'user_id',
        'module_exam_answer_id',
        'text',
        'module_exam_id',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(ModuleExamQuestion::class, 'question_id');
    }

    public function answer(): BelongsTo
    {
        return $this->belongsTo(ModuleExamAnswer::class, 'answer_id');
    }

    public function moduleExam(): BelongsTo
    {
        return $this->belongsTo(ModuleExam::class, 'module_exam_id');
    }

//    public function moduleExamAnswers(): BelongsToMany
//    {
//        return $this->belongsToMany(
//            ModuleExamAnswer::class,
//            'module_exam_user_responses_module_exam_answers',
//            'module_exam_user_response_id',
//            'module_exam_answer_id'
//        );
//    }

    public function moduleExamAnswer(): BelongsTo
    {
        return $this->belongsTo(ModuleExamAnswer::class, 'module_exam_answer_id');
    }


}
