<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;
use Auth;
use Gate;

class CheckGate
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

        $aControllerName = explode('\\',  \Route::currentRouteAction());
        $aControllerName = explode('@', end($aControllerName));

        $aActionName     = $aControllerName[1];
        $aControllerName = $aControllerName[0];

        if ( !Gate::allows('controller-access', \Route::currentRouteAction()) ) {
            return Redirect::away(
                '/registration/error?controller='.$aControllerName.'&action='.$aActionName
            )->send();
        }

        return $next($request);
    }
}


/*
public function handle($request, Closure $next)
    {
        if ($request->input('age') < 200)
        {
            return redirect('home');
        }

        return $next($request);
    }*/