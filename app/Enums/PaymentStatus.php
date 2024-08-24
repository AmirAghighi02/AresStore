<?php

namespace App\Enums;

use App\Contracts\EnumGettersContract;
use App\Traits\EnumWithGetters;

enum PaymentStatus: int implements EnumGettersContract
{
    use EnumWithGetters;

    case FAILED = 0;
    case CANCELLED = 1;
    case PENDING = 2;
    case SUCCESS = 3;
}
