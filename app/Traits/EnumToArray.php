<?php

namespace App\Traits;

trait EnumToArray
{
    public static function name(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function value(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function toArray(): array
    {
        return array_combine(self::name(), self::value());
    }
}
