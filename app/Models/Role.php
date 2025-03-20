<?php

namespace App\Models;

use App\Enums\RoleEnum;
use App\Traits\ModelRelationships\RoleRelationships;
use App\Traits\Modifiers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Role extends Model
{
    use HasFactory, SoftDeletes, RoleRelationships;

    protected $guarded = [];

    public function prettyName()
    {
        return Str::title($this->name);
    }

    public function prettyCapName()
    {
        return Str::upper($this->name);
    }

    public function scopeAdmin(Builder $query): void
    {
        $query->where('name', RoleEnum::ADMIN);
    }

    public function scopeEmployee(Builder $query): void
    {
        $query->where('name', RoleEnum::EMPLOYEE);
    }
}
