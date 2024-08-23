<?php

namespace App\Enums;

use App\Contracts\EnumGettersContract;
use App\Traits\EnumWithGetters;

enum Genders: int implements EnumGettersContract
{
    use EnumWithGetters;
    case MALE = 0;
    case FEMALE = 1;
    case OTHER = 2;
}
