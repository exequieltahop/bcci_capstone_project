<?php

namespace Database\Seeders;

use App\Models\Benefit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BenefitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $benefits = [
            'SSS',
            'GSIS',
            'PhilHealth',
            'Pag-Ibig'
        ];

        foreach($benefits as $benefit) {
            Benefit::create(['name' => $benefit, 'created_by' => 1,
                        'updated_by' => 1]);
        }
    }
}
