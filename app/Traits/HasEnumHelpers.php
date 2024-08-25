<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasEnumHelpers
{
    /**
     * @return array<int, mixed>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * @return array<int, string>
     */
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public function label(): string
    {
        return Str::ucfirst($this->name);
    }
}
