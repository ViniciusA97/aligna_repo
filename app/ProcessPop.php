<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcessPop extends Model
{
    use UsesTenantConnection, SoftDeletes;

    protected $fillable = [
        'process_id', 'pop_id',
    ];

    public function process()
    {
        return $this->belongsTo('App\Process');
    }

    public function pop()
    {
        return $this->belongsTo('App\Pop');
    }
}
