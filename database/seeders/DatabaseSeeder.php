<?php

namespace Database\Seeders;

use App\Enums\EmploymentStatusEnum;
use App\Models\Category;
use App\Models\EmploymentDetail;
use App\Models\LeaveType;
use App\Models\Position;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            BenefitSeeder::class,
            LeaveSeeder::class,
        ]);


        $user = User::factory()->admin()->create(['email' => 'admin@admin.com']);
        $category = Category::create(['name' => 'Managerial']);
        $position = Position::create(['category_id' => $category->id, 'name' => 'Manager']);
        EmploymentDetail::create([
            'user_id' => $user->id,
            'position_id' => $position->id,
            'department' => 'Admin',
            'manager_id' => $user->id,
            'supervisor_id' => $user->id,
            'employment_status' => EmploymentStatusEnum::REGULAR,
            'date_hired' => now(),
            'date_regularized' => now()
        ]);

        $this->call(EmployeeSeeder::class);
    }
}
