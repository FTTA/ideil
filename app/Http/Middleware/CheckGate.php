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

        $lUser = (Auth::check()) ? Auth::user() : null;


        if (!$lUser || !$this->accessDistribute($lUser, \Route::currentRouteAction()) ) {
            return Redirect::away(
                '/registration/error?controller='.$aControllerName.'&action='.$aActionName
            )->send();
        }

        return $next($request);
    }


    public function accessDistribute($aUser, $aRoute) {


            $lRoles = ['admin' => 1, 'guest' => 3];
            $lAccesTable = [

                'ArticlesController' => [
                    'roles'   => [$lRoles['admin'] => true],
                    'actions' => [
                        'add'     => [],
                        'details' => ['any_user' => true],
                        'edit'    => [],
                        'index'   => ['any_user' => true],
                        'manage'  => []
                    ]
                ],

                'CategoriesController' => [
                    'roles'   => [$lRoles['admin'] => true],
                    'actions' => [
                        'add'     => [],
                        'edit'    => [],
                        'index'   => [],
                    ]
                ],

                'CommentsController' => [
                    'roles'   => [$lRoles['admin'] => true],
                    'actions' => [
                        'manage'  => []
                    ]
                ],

                'FileUploaderController' => [
                    'roles'   => ['any_user' => true, $lRoles['guest'] => false],
                    'actions' => [
                        'upload'  => []
                    ]
                ],

                'RegistrationController' => [
                    'roles'   => [$lRoles['guest'] => true],
                    'actions' => [
                        'index'   => [],
                        'confirm' => [],
                        'error'   => ['any_user' => true]
                    ]
                ],

                'UsersController' => [
                    'roles'   => [$lRoles['admin'] => true],
                    'actions' => [
                        'edit'     => [$lRoles['guest'] => true],
                        'profile'  => [$lRoles['guest'] => true],
                        'publicp'  => ['any_user' => true],
                        'users'    => ['any_user' => false, $lRoles['admin'] => true]
                    ]
                ],

                'ArticlesAjaxController' => [
                    'roles'   => [$lRoles['admin'] => true],
                    'actions' => [
                        'add'       => [],
                        'edit'      => [],
                        'published' => [],
                        'delete'    => []
                    ]
                ],

                'CategoriesAjaxController' => [
                    'roles'   => [$lRoles['admin'] => true],
                    'actions' => [
                        'add'     => [],
                        'edit'    => [],
                        'delete'  => []
                    ]
                ],

                'CommentsAjaxController' => [
                    'roles'   => [$lRoles['admin'] => true],
                    'actions' => [
                        'add'      => ['any_user' => true, $lRoles['guest'] => false],
                        'blocking' => []
                    ]
                ],

                'GeneralAjaxController' => [
                    'roles'   => [$lRoles['guest'] => true],
                    'actions' => [
                        'confirm'      => [],
                        'registration' => [],
                        'signIn'       => [],
                        'signOut'      => ['any_user' => true, $lRoles['guest'] => false]
                    ]
                ],

                'UsersAjaxController' => [
                    'roles'   => [$lRoles['guest'] => true, $lRoles['admin'] => true],
                    'actions' => [
                        'changePass' => [],
                        'edit'       => []
                    ]
                ]
            ];

            $lRole = (empty($aUser->role)) ? $lRoles['guest'] : $aUser->role;

            $aControllerName = explode('\\',  $aRoute);
            $aControllerName = explode('@', end($aControllerName));

            $aActionName     = $aControllerName[1];
            $aControllerName = $aControllerName[0];

            if (!isset($lAccesTable[$aControllerName])
                || !isset($lAccesTable[$aControllerName]['actions'][$aActionName])
            )
                throw new Exception('Error Processing Request '.$aControllerName.'/'.$aActionName);

            $lActions = $lAccesTable[$aControllerName]['actions'];
            $lRoles   = $lAccesTable[$aControllerName]['roles'];

            if (isset($lActions[$aActionName][$lRole])) {
                return $lActions[$aActionName][$lRole];
            }

            if (isset($lActions[$aActionName]['any_user'])) {
                return $lActions[$aActionName]['any_user'];
            }

            if (isset($lRoles[$lRole])) {
                return $lRoles[$lRole];
            }

            if (isset($lRoles['any_user'])) {
                return $lRoles['any_user'];
            }

            return false;
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