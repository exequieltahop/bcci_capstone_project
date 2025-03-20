<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

trait Modifiers
{
    use SoftDeletes {
        SoftDeletes::restore as softDeletesRestore;
    }

    public static function boot()
     {
        parent::boot();
        static::creating(function($model)
        {
            $user = Auth::user();
            $model->created_by = $user?->id;
            $model->updated_by = $user?->id;
        });
        static::updating(function($model)
        {
            $user = Auth::user();
            $model->updated_by = $user?->id;
        });

        static::deleting(function($model)
        {
            $model->modifierPerformDeleteOnModel();
            $model->performDeleteOnModel();
        });
    }

    // Override the delete method
    protected function modifierPerformDeleteOnModel()
    {
        if ($this->forceDeleting) {
            // If force deleting, simply delete the model
            $this->delete();
        } else {
            // Update the deleted_by column with the ID of the authenticated user
            $this->deleted_by = Auth::id();
            $this->save();

            // Perform the standard soft delete
            $this->runSoftDelete();
        }
    }

    public function restore()
    {
        $this->deleted_by = null;
        $this->save();

        $this->softDeletesRestore();
        parent::restore();
    }



    /**
     * Relationships
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'id');
    }

}
