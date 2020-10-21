<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\SoftDeletes;

class Process extends Model
{
    use UsesTenantConnection, SoftDeletes;

    public function pops()
    {
        $config = app(\Hyn\Tenancy\Database\Connection::class)->configuration();
        return $this->belongsToMany('App\Pop', "{$config['database']}.process_pops", 'process_id', 'pop_id');
    }
}
