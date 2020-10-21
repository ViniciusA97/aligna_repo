<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\SoftDeletes;

class Upload extends Model
{
    use UsesTenantConnection, SoftDeletes;

    protected $fillable = [
        'pop_id', 'user_id', 'title', 'filename', 'external_url', 'external_bucket', 'external_endpoint', 'provider', 'mine', 'extension', 'size',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function pop()
    {
        return $this->belongsTo('App\Pop');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
