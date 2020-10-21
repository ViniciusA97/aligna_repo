<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\SoftDeletes;

class FunctionPop extends Model
{
    use UsesTenantConnection, SoftDeletes;

    protected $fillable = [
        'pop_id', 'function_id',
    ];

    public function func()
    {
        return $this->belongsTo('App\Functionm', 'function_id');
    }

    // public function pop()
    // {
    //     return $this->belongsTo('App\Pop');
    // }
}
