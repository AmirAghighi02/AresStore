<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasEnumHelpers
{
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public function label(): string
    {
        return Str::ucfirst($this->name);
    }
}
