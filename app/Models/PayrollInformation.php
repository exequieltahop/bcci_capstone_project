<?php

namespace App\Models;

use App\Traits\ModelRelationships\PayrollInformationRelationships;
use App\Traits\Modifiers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayrollInformation extends Model
{
    use HasFactory, Modifiers, PayrollInformationRelationships;

    protected $guarded = [];
}
