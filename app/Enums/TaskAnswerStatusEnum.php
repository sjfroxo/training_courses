<?php

namespace App\Enums;

enum TaskAnswerStatusEnum: int
{
    case NOT_DONE = 0;
    case DONE = 1;
    case INTERN_FREE = 2;

    /**
     * @return string
     */
    public function title(): string
    {
        return match ($this) {
            self::NOT_DONE => 'Не сдано',
            self::DONE => 'Сдано',
            self::INTERN_FREE => 'Освобождён',
        };
    }
}
