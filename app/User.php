<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, UsesTenantConnection, HasApiTokens;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password',
        'email_verified_at', 
        'id_cargo', 
        'id_setor', 
        'last_access',
        'role',
        'send_last_invite',
        'foto_perfil',
        'data_nascimento',
        'url_linkedin',
        'resumo_experiencia',
        'formacao',
        'telefone   '
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
         'remember_token','password'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    

    public function pops()
    {
        return $this->hasMany('App\Pop', 'id', 'user_creator_id');
    }

    public function setor()
    {
        return $this->belongsTo('App\Setor', 'id_setor');
    }

    public function cargo()
    {
        return $this->belongsTo('App\Cargo', 'id_cargo');
    }

    public function popVersions()
    {
        return $this->hasMany('App\PopHistoric', 'id', 'user_creator_id');
    }

    public function uploads()
    {
        return $this->hasMany('App\Upload', 'id', 'user_creator_id');
    }
}
