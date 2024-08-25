<?php

namespace App\Contracts;

interface EnumHelpersContract
{
    /**
     * @return array<int, string|int>
     */
    public static function values(): array;

    /**
     * @return array<int, string>
     */
    public static function names(): array;

    public function label(): string;
}
