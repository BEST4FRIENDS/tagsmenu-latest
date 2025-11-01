<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule; 
use App\Jobs\UpdateTrendingDataJob;      

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


// --- NEU: Führe unseren Analyse-Job jeden Tag um 01:00 Uhr nachts aus. ---
Schedule::job(new UpdateTrendingDataJob())->dailyAt('01:00');