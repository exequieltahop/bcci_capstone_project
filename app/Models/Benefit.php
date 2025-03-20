<?php

namespace App\Models;

use App\Traits\Modifiers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Benefit extends Model
{
    use HasFactory, Modifiers;

    protected $guarded = [];
}
