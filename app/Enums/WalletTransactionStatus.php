<?php

namespace App\Enums;

use App\Contracts\EnumHelpersContract;
use App\Traits\HasEnumHelpers;

enum WalletTransactionStatus: int implements EnumHelpersContract
{
    use HasEnumHelpers;

    case FAILED = 0;
    case INITIAL = 1;
    case CONFIRMED = 2;
}
