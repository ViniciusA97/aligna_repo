<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\SoftDeletes;

class PopHistoric extends Model
{
    use UsesTenantConnection, SoftDeletes;

    protected $fillable = [
        'pop_id', 'title', 'description', 'resume', 'recurrence_id', 'hours', 'pdca', 'status_preenchimento', 'status_execucao', 'perfil', 'user_creator_id', 'user_updated_by', 'start_at'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'start_at'];

    public function pop()
    {
        return $this->belongsTo('App\Pop');
    }

    public function recurrence()
    {
        return $this->belongsTo('App\Recurrence');
    }

    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_creator_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'user_updated_by');
    }
}
