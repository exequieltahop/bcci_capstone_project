<?php

use App\Jobs\BiMonthlyPayroll;
use App\Jobs\MonthlyPayroll;
use App\Jobs\WeeklyPayroll;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    (new MonthlyPayroll)->dispatchSync();
})->lastDayOfMonth('20:00');

Schedule::call(function () {
    (new WeeklyPayroll)->dispatchSync();
})->weeklyOn(6, '20:00');

$endDayOfMonth = now()->endOfMonth()->format('m');
Schedule::call(function () {
    (new BiMonthlyPayroll)->dispatchSync();
})
    ->twiceMonthly(15, $endDayOfMonth, '20:00');
