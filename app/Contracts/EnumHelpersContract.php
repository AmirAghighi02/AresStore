<?php

namespace App\Contracts;

interface EnumHelpersContract
{
    public static function values(): array;

    public static function names(): array;

    public function label(): string;
}
