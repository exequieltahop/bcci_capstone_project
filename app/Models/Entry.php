<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class Entry extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['user_id', 'clock_in', 'clock_out', 'status'];
    protected $casts    = [
        'clock_in'   => 'datetime',
        'clock_out'  => 'datetime',
        'status'     => StatusEnum::class,
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function (Entry $entry) {
            $entry->created_by = Auth::id();
            $entry->status     = StatusEnum::ACTIVE;
        });

        static::updating(function (Entry $entry) {
            $entry->updated_by = Auth::id();
        });

        static::deleting(function (Entry $entry) {
            $entry->deleted_by = Auth::id();
            $entry->status     = StatusEnum::INACTIVE;
            $entry->save();
        });
    }

    public function tardiness(): Attribute
    {
        $instance = $this;

        return Attribute::make(
            get: function () use ($instance) {
                $tardiness       = 0;
                $expectedClockIn = $instance->clock_in->copy()->setHour((int) config('app.clock_in'))->startOfHour();

                if ($instance->clock_in->greaterThan($expectedClockIn)) {
                    $tardiness = ceil($expectedClockIn->diffInMinutes($instance->clock_in));
                }

                return $tardiness;
            }
        );
    }

    public function undertime(): Attribute
    {
        $instance = $this;

        return Attribute::make(
            get: function () use ($instance) {
                if ($instance->clock_out === null) {
                    return 0;
                }

                $undertime        = 0;
                $expectedClockOut = $instance->clock_in->copy()->setHour((int) config('app.clock_out'))->startOfHour();

                if ($instance->clock_out->lessThan($expectedClockOut)) {
                    $undertime = ceil($instance->clock_out->diffInMinutes($expectedClockOut));
                }

                return $undertime;
            }
        );
    }

    public function hoursWorked(): Attribute
    {
        $instance = $this;

        return Attribute::make(
            get: function () use ($instance) {
                if ($instance->clock_out === null) {
                    return 0;
                }

                $hoursWorked = $instance->clock_in->diffInMinutes($instance->clock_out) - ($instance->tardiness + $instance->undertime);
                $hoursWorked = round((($hoursWorked / 60) - 1), 2);

                return $hoursWorked;
            }
        );
    }

    public function overtime(): HasOne
    {
        return $this->hasOne(Overtime::class, 'entry_id');
    }

    public function user(): BelongsTo
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

    // GET TODAYS ENTRY/ ATTENDANCE
    public function get_todays_attendance_both() {
        try {
            $data = $this->select('*');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
