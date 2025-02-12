<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum UserRolesEnum: int
{
    use EnumTrait;

    case USER = 1;
    case ADMIN = 2;

    public function title(): string
    {
        return match ($this) {
            self::USER => 'Пользователь',
            self::ADMIN => 'Администратор',
            default => 'Неизвестный статус',
        };
    }
}
