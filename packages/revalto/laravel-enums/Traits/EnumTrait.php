<?php

namespace App\Traits;

use Illuminate\Support\Collection;

trait EnumTrait
{
    /**
     * @return array
     */
    public static function toArray(): array
    {
        return array_map(fn($res) => $res->value, self::cases());
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

        foreach (self::cases() as $item) {
            $pluckValue = method_exists($item, $value) ? $item->{$value}() : $item->{$value};

            if(is_null($key)) {
                $result[] = $pluckValue;
            } else {
                $result[method_exists($item, $key) ? $item->{$key}() : $item->{$key}] = $pluckValue;
            }
        }

        return $result;
    }
}
