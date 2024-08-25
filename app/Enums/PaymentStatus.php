<?php

namespace App\Enums;

use App\Contracts\EnumHelpersContract;
use App\Traits\HasEnumHelpers;

enum PaymentStatus: int implements EnumHelpersContract
{
    use HasEnumHelpers;

    case FAILED = 0;
    case CANCELLED = 1;
    case PENDING = 2;
    case SUCCESS = 3;
}
