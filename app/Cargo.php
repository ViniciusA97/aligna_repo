<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cargo extends Model
{
    use UsesTenantConnection;

    protected $table="cargo";

    public $timestamps = false;

    protected $fillable = [
        'name', 'resumo', 'descricao', 'active'
    ];

    public function users()
    {
        return $this->hasMany('App\User', 'id_cargo', 'id');
    }


}
