<?php

namespace App\Http\Middleware;

use Closure;

class CheckScope
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        if(is_null($user)){
            return response()-json(['success'=>false,'error'=>'Token invalido'],401);
        }
        if($user->role != 'Administrador'){
            return response()->json(['success'=>false,'error'=>'Escopo do usuário não permite realizar essa ação.'],403);
        }
        return $next($request);
    }
}
