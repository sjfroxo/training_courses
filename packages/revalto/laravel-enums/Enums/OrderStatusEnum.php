<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum OrderStatusEnum: int
{
    use EnumTrait;

    case SUCCESS = 1; // Ставится после успешной оплаты
    case NEW = 2; // Ставится при создании платежа
    case IN_PROCESS = 3; // Ставится после генерации ссылки от платежной системы
    case ERROR = 4; // Ставится в случае ошибки

    /**
     * @return string
     */
    public function title(): string
    {
        return match($this) {
            self::SUCCESS => 'Оплата прошла',
            self::NEW => 'Новый платеж',
            self::IN_PROCESS => 'Сгенерирована ссылка',
            self::ERROR => 'Ошибка',
            default => 'Неизвестный статус',
        };
    }
}
