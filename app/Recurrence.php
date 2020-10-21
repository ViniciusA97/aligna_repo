<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recurrence extends Model
{
    use UsesTenantConnection, SoftDeletes;

    protected $fillable = [
        'user_creator_id', 'rrule', 'start_date', 'end_date',
    ];

    protected $dates = ['start_date', 'end_date', 'created_at', 'updated_at', 'deleted_at'];

    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_creator_id');
    }

    public function getRruleAttribute($value)
    {
        return unserialize($value);
    }
}
