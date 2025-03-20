<?php

namespace App\Models;

use App\Traits\ModelRelationships\LeaveRelationships;
use App\Traits\Modifiers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leave extends Model
{
    use HasFactory, Modifiers, LeaveRelationships;

    protected $guarded = [];
}
