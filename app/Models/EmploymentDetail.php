<?php

namespace App\Models;

use App\Traits\ModelRelationships\EmploymentDetailRelationships;
use App\Traits\Modifiers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmploymentDetail extends Model
{
    use HasFactory, Modifiers, EmploymentDetailRelationships;

    protected $guarded = [];
}
