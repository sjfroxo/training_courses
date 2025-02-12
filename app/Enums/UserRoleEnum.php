<?php

namespace App\Enums;

use App\Traits\HasRoles;

enum UserRoleEnum: int
{
    use HasRoles;

    case USER = 1;
    case CURATOR = 2;
    case ADMIN = 3;

    public function title(): string
    {
        return match ($this) {
            self::USER => 'Пользователь',
            self::CURATOR => 'Куратор',
            self::ADMIN => 'Администратор',
            default => 'Неизвестный статус',
        };
    }
}
