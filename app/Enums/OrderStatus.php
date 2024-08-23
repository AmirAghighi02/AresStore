<?php

namespace App\Enums;

use App\Contracts\EnumGettersContract;
use App\Traits\EnumWithGetters;

enum OrderStatus: int implements EnumGettersContract
{
    use EnumWithGetters;
    case PENDING = 0;
    case SENT = 1;
    case SHIPPED = 2;
    case CANCELLED_BY_SELLER = 3;
    case CANCELLED_BY_COSTUMER = 4;
    case CANCELLED_BY_ADMIN = 5;
}
