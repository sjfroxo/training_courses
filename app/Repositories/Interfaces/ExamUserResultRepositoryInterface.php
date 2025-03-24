<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;
use Revalto\ServiceRepository\Repository\AbstractRepositoryInterface;

interface ExamUserResultRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param string $moduleExamId
     * @return Collection
     */
    public function getResponsesForExam(string $moduleExamId): Collection;

    /**
     * @param string $moduleExamId
     * @return int
     */
    public function getTotalQuestions(string $moduleExamId): int;

    /**
     * @param string $moduleExamId
     * @return array
     */
    public function calculateResults(string $moduleExamId): array;
}
