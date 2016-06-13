<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
/*
        $gate->define('controller-access', function ($aUser, $aRoute) {

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
                    'roles'   => ['any_user' => true, $lRoles['guest'] => false],
                    'actions' => [
                        'edit'     => [],
                        'profile'  => [],
                        'publicp'  => [$lRoles['guest'] => true],
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
                    'roles'   => ['any_user' => true, $lRoles['guest'] => false],
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

            if (isset($lActions[$aActionName][$lRole['role_id']])) {
                return $lActions[$aActionName][$lRole['role_id']];
            }

            if (isset($lActions[$aActionName]['any_user'])) {
                return $lActions[$aActionName]['any_user'];
            }

            if (isset($lRoles[$lRole['role_id']])) {
                return $lRoles[$lRole['role_id']];
            }

            if (isset($lRoles['any_user'])) {
                return $lRoles['any_user'];
            }

            return false;
        });*/

    }
}
