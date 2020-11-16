<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;

class UpdateLastAsccess
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
        

        date_default_timezone_set("America/recife");
        $user->update([
            'last_access' => Carbon::now()
        ]);

        return $next($request);
    }
}
