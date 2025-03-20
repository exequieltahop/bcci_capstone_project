<?php

namespace App\Models;

use App\Traits\Modifiers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, Modifiers;

    protected $guarded = [];

    public function positions()
    {
        return $this->hasMany(Position::class, 'category_id');
    }
}
