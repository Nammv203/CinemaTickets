<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait TraitsHasAudit
{
    public static function bootTraitsHasAudit()
    {
        // Automatically fill created_by on create
        static::creating(function ($model) {
            $model->created_by = Auth::check() ? Auth::id() : null;
        });

        // Automatically fill updated_by on update
        static::updating(function ($model) {
            $model->updated_by = Auth::check() ? Auth::id() : null;
        });

        // Automatically fill deleted_by on delete
        static::deleting(function ($model) {
            if ($model->usesSoftDeletes()) {
                $model->deleted_by = Auth::check() ? Auth::id() : null;
                $model->save();
            }
        });

        static::created(function ($model) {
            // create ticket_number in ticket_orders
            if($model->table == 'ticket_orders'){
                $model->ticket_number = str_pad($model->id, 6, '0', STR_PAD_LEFT);
                $model->save();
            }
        });
    }

    /**
     * Determine if the model is using soft deletes.
     */
    protected function usesSoftDeletes()
    {
        return in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this));
    }
}
