<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pop extends Model
{
    use UsesTenantConnection, SoftDeletes;

    protected $fillable = [
        'user_creator_id', 'recurrence_id',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('hasversion', function (Builder $builder) {
            $builder->whereNotNull('active_version_id');
        });
    }

    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_creator_id');
    }

    public function recurrence()
    {
        return $this->belongsTo('App\Recurrence');
    }

    public function functions()
    {
        $config = app(\Hyn\Tenancy\Database\Connection::class)->configuration();
        return $this->belongsToMany('App\Functionm', "{$config['database']}.function_pops", 'pop_id', 'function_id');
    }

    public function processes()
    {
        $config = app(\Hyn\Tenancy\Database\Connection::class)->configuration();
        return $this->belongsToMany('App\Process', "{$config['database']}.process_pops", 'pop_id', 'process_id');
    }

    public function uploads()
    {
        return $this->hasMany('App\Upload', 'pop_id', 'id');
    }

    public function version()
    {
        return $this->hasOne('App\PopHistoric', 'id', 'active_version_id');
    }

    public function versions()
    {
        return $this->hasMany('App\PopHistoric', 'pop_id', 'id');
    }

}
