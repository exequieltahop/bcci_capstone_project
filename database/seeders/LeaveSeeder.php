<?php

namespace Database\Seeders;

use App\Models\Leave;
use App\Models\LeaveType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leaves = [
            'Sick Leave',
            'Vacation Leave',
            'Family Medical Leave Act',
            'Study leave',
            'Carers leave'
        ];

        foreach($leaves as $leave) {
            LeaveType::create(['name' => $leave, 'is_paid' => true, 'created_by' => 1,
                        'updated_by' => 1]);
            LeaveType::create(['name' => $leave, 'is_paid' => false, 'created_by' => 1,
                        'updated_by' => 1]);
        }
    }
}
