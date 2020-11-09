<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class PasswordReset extends Model
{
    use UsesTenantConnection;

    public $timestamps = false;
    protected $table="password_resets";
    protected $fillable = [
        'email', 'token'
    ];
}

?>