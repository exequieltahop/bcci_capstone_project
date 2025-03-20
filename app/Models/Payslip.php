<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "start_date",
        "end_date",
        "total_earn",
        "total_deductions",
        "overall_total",
        "status",
    ];

    public function dateRange(): Attribute
    {
        $startDate = Carbon::parse($this->start_date)->format('M d, Y');
        $endDate = Carbon::parse($this->end_date)->format('M d, Y');

        return Attribute::make(
            get: fn() => "{$startDate} - {$endDate}"
        );
    }
}
