<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Support\Facades\Auth;

class Overtime extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'entry_id',
        'user_id',
        'time_start',
        'time_end',
        'purpose',
        'comment',
    ];
    protected $casts = [
        'time_start'      => 'datetime',
        'time_end'        => 'datetime',
        'status'          => StatusEnum::class,
        'is_sp_approved'  => 'boolean',
        'is_mng_approved' => 'boolean',
        'updated_at'      => 'datetime',
        'created_at'      => 'datetime',
        'deleted_at'      => 'datetime',
    ];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function (Overtime $overtime) {
            $overtime->created_by = Auth::id();
            $overtime->status     = StatusEnum::PENDING;
        });

        static::updating(function (Overtime $overtime) {
            $overtime->updated_by = Auth::id();
        });

        static::deleting(function (Overtime $overtime) {
            $overtime->deleted_by = Auth::id();
            $overtime->status     = StatusEnum::CANCELLED;
            $overtime->save();
        });
    }

    public function totalHours(): Attribute
    {
        $instance = $this;

        return new Attribute(
            get: function () use ($instance) {
                $totalHours = $instance->time_start->diffInMinutes($instance->time_end);
                $totalHours = round(($totalHours / 60), 2);

                return $totalHours;
            }
        );
    }

    public function entry(): BelongsTo
    {
        return $this->belongsTo(Entry::class, 'entry_id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'delete_by');
    }
}
