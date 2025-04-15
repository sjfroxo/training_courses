<?php

namespace App\Actions;

use App\Repositories\CourseRepository;

class CalculateAverageMarkAction
{
    public function __construct(
        protected CourseRepository $repository
    )
    {
    }

    /**
     * @param string $slug
     *
     * @return array
     */
    public function handle(string $slug): array
    {
        $course = $this->repository->findBySlug($slug);
        $users = $course->users;
        $userAverages = [];

        $courseModuleExamIds = $course->modules->flatMap(function ($module) {
            return $module->moduleExams->pluck('id');
        })->toArray();

        foreach ($users as $user) {
            $userModuleExamIds = $user->moduleExams->pluck('pivot.module_exam_id')->toArray();
            $intersection = array_intersect($userModuleExamIds, $courseModuleExamIds);
            if (!empty($intersection)) {
                $marks = $user->moduleExams
                    ->whereIn('pivot.module_exam_id', $intersection)
                    ->pluck('pivot.mark')
                    ->toArray();
                $averageGrade = array_sum($marks) / count($marks);
                $userAverages[$user->id] = $averageGrade;
            }
        }

        return $userAverages;
    }
}
