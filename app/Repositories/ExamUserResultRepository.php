<?php

namespace App\Repositories;

use App\Models\ExamUserResult;
use App\Models\ModuleExamUserResponse;
use App\Models\ModuleExamQuestion;
use App\Repositories\Interfaces\ExamUserResultRepositoryInterface;
use Illuminate\Support\Collection;

class ExamUserResultRepository extends CoreRepository implements ExamUserResultRepositoryInterface
{
    /**
     * Конструктор репозитория.
     *
     * @param mixed $model
     */
    public function __construct(ExamUserResult $model)
    {
        parent::__construct($model);
    }

    /**
     * Получаем все ответы пользователей по тесту.
     *
     * @param string $moduleExamId
     * @return Collection
     */
    public function getResponsesForExam(string $moduleExamId): Collection
    {
        return ModuleExamUserResponse::query()
            ->with('moduleExamAnswer')
            ->where('module_exam_id', $moduleExamId)
            ->get();
    }

    /**
     * Получаем общее количество вопросов для теста.
     *
     * @param string $moduleExamId
     * @return int
     */
    public function getTotalQuestions(string $moduleExamId): int
    {
        return ModuleExamQuestion::query()
            ->where('module_exam_id', $moduleExamId)
            ->count();
    }

    /**
     * Рассчитываем результаты теста.
     *
     * @param string $moduleExamId
     * @return array
     */
    public function calculateResults(string $moduleExamId): array
    {
        $responses = $this->getResponsesForExam($moduleExamId);

        $correctCount = $responses->filter(function ($response) {
            return $response->moduleExamAnswer && $response->moduleExamAnswer->is_correct == 1;
        })->count();

        $questionsCount = $this->getTotalQuestions($moduleExamId);
        $percent = $questionsCount ? round(($correctCount / $questionsCount) * 10) : 0;

        return [
            'correct' => $correctCount,
            'total'   => $questionsCount,
            'percent' => $percent,
        ];
    }
}
