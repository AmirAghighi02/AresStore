<?php

namespace App\Enums;

use App\Contracts\EnumHelpersContract;
use App\Traits\HasEnumHelpers;

enum WalletStatus: int implements EnumHelpersContract
{
    use HasEnumHelpers;

    case DISABLED = 0;
    case ACTIVE = 1;
}
