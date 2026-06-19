<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Auto-end sessions that exceed the maximum duration
Schedule::call(function () {
    app(\App\Services\SessionService::class)->checkAndAutoEnd();
})->everyFiveMinutes()->name('session-auto-end')->withoutOverlapping();

// ─────────────────────────────────────────────────────────────────────────────
// Queue processing — cPanel shared hosting
//
// On shared hosting there is no persistent queue worker.
// The cron below (added in cPanel → Cron Jobs) runs every minute:
//
//   * * * * * /usr/local/bin/php /home/USER/teachmeapp/artisan queue:work
//             --stop-when-empty --queue=notifications,invoices,default --max-time=55
//             >> /dev/null 2>&1
//
// The Schedule::command below is a BACKUP in case cron is unavailable — it
// piggybacks on the scheduler cron (which runs every minute) to drain the queue.
// Having both active is harmless: --stop-when-empty means both exit quickly.
// ─────────────────────────────────────────────────────────────────────────────
Schedule::command('queue:work', [
    '--stop-when-empty',
    '--queue=notifications,invoices,default',
    '--max-time=55',
    '--tries=3',
])->everyTenSeconds()->name('queue-drain')->withoutOverlapping(60);