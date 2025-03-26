<?php

namespace App\Enums;

use App\Traits\HasRoles;

enum UserRoleEnum: int
{
    use HasRoles;

    case UNVERIFIED = 0;
    case USER = 1;
    case CURATOR = 2;
    case ADMIN = 3;
    case DECLINED = 6;

    /**
     * @return string
     */
    public function title(): string
    {
        return match ($this) {
            self::UNVERIFIED => '-',
            self::USER => 'Пользователь',
            self::CURATOR => 'Куратор',
            self::ADMIN => 'Администратор',
            self::DECLINED => 'Отказано в доступе',
        };
    }
}
