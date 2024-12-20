<?php declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumTrait;

enum TypeEnum: string
{
    use EnumTrait;

    case MINECRAFT = 'minecraft';
    case STEAM = 'steam';
    case XBL = 'xbl';
}
