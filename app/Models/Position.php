<?php

namespace App\Models;

use App\Traits\Modifiers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Position extends Model
{
    use HasFactory, Modifiers;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function employmentDetails()
    {
        return $this->hasMany(EmploymentDetail::class, 'position_id');
    }
}
