<?php declare(strict_types=1);

namespace App\Traits;

trait EnumTrait
{
    public static function values(): array
    {
        $cases = static::cases();

        return array_column(
            $cases,
            $cases[0] instanceof \BackedEnum ? 'value' : 'name'
        );
    }
}
