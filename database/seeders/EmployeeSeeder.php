<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Jobs\BiMonthlyPayroll;
use App\Jobs\MonthlyPayroll;
use App\Jobs\WeeklyPayroll;
use App\Models\Deduction;
use App\Models\EmploymentDetail;
use App\Models\Entry;
use App\Models\Overtime;
use App\Models\PayrollInformation;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(3)
            ->sequence(fn(Sequence $sequence) => ['employee_code' => (1000 + ($sequence->index + 1)), 'email' => 'user' . $sequence->index + 1 . '@example.com'])
            ->has(EmploymentDetail::factory(), 'employmentDetail')
            ->has(PayrollInformation::factory(), 'payrollInformation')
            ->has(Deduction::factory(2), 'deductions')
            ->has(Entry::factory(6)->sequence(function (Sequence $sequence) {
                return [
                    'clock_in' => now()->setHour((int) config('app.clock_in'))->setMinute(0)->setSecond(0)->subDays($sequence->index + 1),
                    'clock_out' => now()->setHour((int) config('app.clock_out'))->setMinute(0)->setSecond(0)->subDays($sequence->index + 1)->addMinutes(120),
                ];
            })
                ->has(Overtime::factory()->state(function (array $attributes, Entry $entry) {
                    return [
                        'user_id' => $entry->user->id,
                        'entry_id' => $entry->id,
                        'time_start' => Carbon::parse($entry->clock_out)->subMinutes(120),
                        'time_end' => Carbon::parse($entry->clock_out)->addMinutes(120),
                        'created_by' => $entry->user->id,
                        'updated_by' => $entry->user->id
                    ];
                }), 'overtime'), 'entries')
            ->create(['role_id' => Role::where('name', RoleEnum::EMPLOYEE->value)->first()?->id]);

        WeeklyPayroll::dispatchSync();
        MonthlyPayroll::dispatchSync();
        BiMonthlyPayroll::dispatchSync();
    }
}
