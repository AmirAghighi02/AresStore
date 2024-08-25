<?php

namespace App\Enums;

use App\Contracts\EnumHelpersContract;
use App\Traits\HasEnumHelpers;

enum Genders: int implements EnumHelpersContract
{
    use HasEnumHelpers;
    case MALE = 0;
    case FEMALE = 1;
    case OTHER = 2;
}
