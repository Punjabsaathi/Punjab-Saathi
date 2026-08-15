<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Shared hosting (e.g. Hostinger) can't run a persistent `queue:work` daemon,
// so form-submission emails queued via Mail::queue() would otherwise sit in
// the `jobs` table forever. Draining the queue once a minute via the
// scheduler is the standard workaround — requires one cron entry on the
// server: `* * * * * php artisan schedule:run`.
Schedule::command('queue:work --stop-when-empty --tries=3 --max-time=50')
    ->everyMinute()
    ->withoutOverlapping();
