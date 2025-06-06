<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('app:gerar-missoes-diarias')
    ->dailyAt('00:00');
    //->everyMinute();
    //->timezone('Europe/Lisbon');

Schedule::command('app:verificar-streaks')
    //->dailyAt('00:00')
    ->hourly();
    //->timezone('Europe/Lisbon');