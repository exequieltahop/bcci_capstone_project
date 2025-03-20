<?php

namespace App\Jobs;

use App\Classes\PaySlipCalculator;
use App\Classes\Semaphore;
use App\Enums\PayModeEnum;
use App\Models\Payslip;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class MonthlyPayroll implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $monthlyEmployees = User::whereHas('payrollInformation', function ($query) {
            $query->where('pay_mode', PayModeEnum::MONTHLY->value);
        })->with(['entries' => function ($query) {
            $startOfMonth = now()->startOfMonth();
            $endOfMonth = now()->endOfMonth();

            $query->where('clock_in', '>=', $startOfMonth)
                ->where('clock_out', '<=', $endOfMonth);
        }, 'deductions'])->get();

        $monthlyEmployees->each(function ($employee) {
            $rate = $employee->payrollInformation->basic_salary;
            $workingDays = PaySlipCalculator::getWorkingDaysByMonth();
            $hourlyRate = PaySlipCalculator::getHourlyRate($workingDays,$rate);

            $totalHours = $employee->entries->map(function ($entry) {
                [
                    'hour_worked' => $hoursWorked
                ] = PaySlipCalculator::calculateWorkingHours($entry->clock_in, $entry->clock_out);

                return collect(['worked_hours' => $hoursWorked]);
            })->sum('worked_hours');

            $totalEarn = $totalHours * $hourlyRate;
            $totalDeductions = $employee->deductions->sum('amount');
            $overAllTotal = $totalEarn - $totalDeductions;

            $payslip = Payslip::create([
                "user_id" => $employee->id,
                "start_date" => now()->startOfMonth(),
                "end_date" => now()->endOfMonth(),
                "total_earn" => $totalEarn,
                "total_deductions" => $totalDeductions,
                "overall_total" => $overAllTotal,
            ]);

            Semaphore::send($employee->contact_number, "Hello {$employee->fullName}, your salary for {$payslip->start_date->format('M d, Y')} - {$payslip->end_date->format('M d, Y')} has been generated and is now available. Please check the employee portal to view it. If you have any questions, feel free to reach out. Thank you!");
        });
    }
}
