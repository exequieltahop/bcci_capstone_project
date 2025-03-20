<?php

namespace App\Models;

use App\Traits\ModelRelationships\DeductionRelationships;
use App\Traits\Modifiers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deduction extends Model
{
    use HasFactory, Modifiers, DeductionRelationships;

    protected $guarded = [];
}
