<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

use Config;

use View;
//use Illuminate\Contracts\Auth\Authenticatable;
use Auth;
use Gate;
use Illuminate\Support\Facades\Redirect;

abstract class ParentController extends BaseController
{

	use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;


    function __construct()
    {
        $lMenuView = 'menu_block';

        if (Auth::check()) {
            $this->current_user = Auth::user();
            $this->is_logged = true;
/*
            foreach ($this->current_user->roles as $lVal) {
                if (AuthModule::UR_ADMIN == $lVal->role_id) {
                    $lMenuView = 'menu_block_admin';
                    break;
                }
            }*/
        }
        else {
            $this->current_user = false;
            $this->is_logged = false;
        }
/*
        $aControllerName = explode('\\',  \Route::currentRouteAction());
        $aControllerName = explode('@', end($aControllerName));

        $aActionName     = $aControllerName[1];
        $aControllerName = $aControllerName[0];

        if (!Gate::allows('controller-access', \Route::currentRouteAction()) && $aActionName != 'error') {
            return Redirect::away(
                '/registration/error?controller='.$aControllerName.'&action='.$aActionName
            )->send();
        }*/

        $this->storage   = Config::get('common.storage');
        $this->content   = Config::get('common.content');
        $this->page_size = Config::get('common.page_size');

        View::share('is_logged', $this->is_logged);
        View::share('current_user', $this->current_user);
        View::share('content', $this->content);
        View::share('storage', $this->storage);



       //parent::__construct();
       //print "Конструктор класа SubClass\n";
   }

}
