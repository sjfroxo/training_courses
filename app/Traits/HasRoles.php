<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use ReflectionClass;

trait HasRoles
{
    /**
     * @return array
     */
    public static function toArray(): array
    {
        return array_map(fn($res) => $res->value, self::getConstants());
    }

    /**
     * @return Collection
     */
    public static function toCollection(): Collection
    {
        return collect(self::toArray());
    }

    /**
     * @param string $value
     * @param string|null $key
     * @return array
     */
    public static function pluck(string $value, string $key = null): array
    {
        $result = [];

        foreach (self::getConstants() as $item) {
            $pluckValue = method_exists($item, $value) ? $item->{$value}() : $item->{$value};

            if (is_null($key)) {
                $result[] = $pluckValue;
            } else {
                $result[method_exists($item, $key) ? $item->{$key}() : $item->{$key}] = $pluckValue;
            }
        }

        return $result;
    }

    /**
     * Получить все константы класса Enum.
     *
     * @return array
     */
    private static function getConstants(): array
    {
        $reflection = new ReflectionClass(self::class);
        $constants = $reflection->getConstants();

        // Преобразовать константы в массив объектов Enum
        $enumObjects = [];
        foreach ($constants as $key => $value) {
            $enumObjects[] = new self($value);
        }

        return $enumObjects;
    }
}
