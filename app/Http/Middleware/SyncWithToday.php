<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;
use Modules\Trip\Entities\Day;

class SyncWithToday
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if(Auth::user()->hasRole('pengawas')){
            $today = getToday();

            if(!$today->pengawas){
                return redirect()->route('pengawasLogin');
            }
        }

        return $next($request);
    }
}
