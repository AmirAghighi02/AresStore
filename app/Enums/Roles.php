<?php

namespace App\Enums;

use App\Contracts\EnumHelpersContract;
use App\Traits\HasEnumHelpers;

enum Roles: string implements EnumHelpersContract
{
    use HasEnumHelpers;

    case SUPER_ADMIN = 'super-admin';
    case ADMIN = 'admin';
    case COSTUMER = 'costumer';
    case SELLER = 'seller';
}
