<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('pint', function () {
    $pint = Process::timeout(2000)->run('./vendor/bin/pint');
    $this->info($pint->output());

    return 0;
});

Artisan::command('stan', function () {
    $stan = Process::timeout(2000)->run('./vendor/bin/phpstan analyse');
    $this->info($stan->output());

    return 0;
});
