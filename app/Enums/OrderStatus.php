<?php

namespace App\Enums;

use App\Contracts\EnumHelpersContract;
use App\Traits\HasEnumHelpers;

enum OrderStatus: int implements EnumHelpersContract
{
    use HasEnumHelpers;
    case PENDING = 0;
    case SENT = 1;
    case SHIPPED = 2;
    case CANCELLED_BY_SELLER = 3;
    case CANCELLED_BY_COSTUMER = 4;
    case CANCELLED_BY_ADMIN = 5;
}
