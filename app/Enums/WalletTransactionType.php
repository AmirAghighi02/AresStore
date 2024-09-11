<?php

namespace App\Enums;

use App\Contracts\EnumHelpersContract;
use App\Traits\HasEnumHelpers;

enum WalletTransactionType: int implements EnumHelpersContract
{
    use HasEnumHelpers;

    case WITHDRAW = 0;
    case MANUAL_CHARGE = 1;
    case CANCELED_PURCHASE_CHARGE = 2;
}
