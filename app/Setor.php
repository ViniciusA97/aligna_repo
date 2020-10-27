<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setor extends Model
{
    use UsesTenantConnection;

    protected $table="setor";
    public $timestamps = false;

    protected $fillable = [
        'name', 'descricao', 'active'
    ];
}
