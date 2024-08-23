<?php

namespace App\Contracts;

interface EnumGettersContract
{
    public static function values(): array;
    public static function names(): array;
}
