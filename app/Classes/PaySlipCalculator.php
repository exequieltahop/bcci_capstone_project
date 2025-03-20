<?php

namespace App\Classes;

use Carbon\Carbon;

class PaySlipCalculator
{
    public static function calculateWorkingHours($clockInString, $clockOutString)
    {
        $clockIn = Carbon::parse($clockInString);
        $clockOut = Carbon::parse($clockOutString);

        $appClockIn = (int) config('app.clock_in');
        $appClockOut = (int) config('app.clock_out');
        $clockInThreshold = Carbon::parse("{$clockIn->format('Y-m-d')} {$appClockIn}:00:00");
        $clockOutThreshold = Carbon::parse("{$clockOut->format('Y-m-d')} {$appClockOut}:00:00");

        if ($clockIn < $clockInThreshold) {
            $clockIn = $clockInThreshold;
        }

        if ($clockOut > $clockOutThreshold) {
            $clockOut = $clockOutThreshold;
        }

        // Calculate the difference in minutes
        $minutesWorked = $clockIn->diffInMinutes($clockOut);

        // Calculate the difference in hours
        $hoursWorked = $clockIn->diffInHours($clockOut);

        return [
            'minute_worked' => $minutesWorked - 60,
            'hour_worked' => $hoursWorked - 1,
        ];
    }

    public static function getWorkingDaysByMonth()
    {
        $startOfMonth = now()->startOfMonth(); // Get the first day of the current month
        $endOfMonth = now()->endOfMonth(); // Get the last day of the current month

        // Initialize the count of Sundays
        $workingDays = 0;

        // Loop through all days in the month
        while ($startOfMonth <= $endOfMonth) {
            // Check if the current day is a Sunday
            if (!$startOfMonth->isSunday()) {
                $workingDays++;
            }
            // Move to the next day
            $startOfMonth->addDay();
        }

        return $workingDays;
    }

    public static function getWorkingDaysByBiMonth()
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        $middleDayOfMonth = $startOfMonth->copy()->addDays(floor($startOfMonth->diffInDays($endOfMonth) / 2));

        if(now() == $middleDayOfMonth) {
            $startOfMonth = $middleDayOfMonth;
        } else {
            $endOfMonth = $middleDayOfMonth;
        }

        // Initialize the count of Sundays
        $workingDays = 0;

        // Loop through all days in the month
        while ($startOfMonth <= $endOfMonth) {
            // Check if the current day is a Sunday
            if (!$startOfMonth->isSunday()) {
                $workingDays++;
            }
            // Move to the next day
            $startOfMonth->addDay();
        }

        return $workingDays;
    }

    public static function getWeeksByMonth()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Initialize the week count
        $weekCount = 0;

        // Loop through the month in weeks
        while ($startOfMonth->lte($endOfMonth)) {
            // Count this week
            $weekCount++;

            // Move the start of the month forward by 7 days (one week)
            $startOfMonth->addWeek();
        }

        return $weekCount;
    }

    public static function getHourlyRate($workingDays, $rate)
    {
        $dailyHours = 8;

        $totalHoursWorked = $workingDays * $dailyHours;
        $hourlyRate = $rate / $totalHoursWorked;

        return $hourlyRate;
    }
}
