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
            $this->is_logged    = true;
            $this->is_admin = ($this->current_user->role === 1) ? true : false;
        }
        else {
            $this->current_user = false;
            $this->is_logged    = false;
            $this->is_admin     = false;
        }

        $this->storage   = Config::get('common.storage');
        $this->content   = Config::get('common.content');
        $this->page_size = Config::get('common.page_size');

        View::share('is_logged', $this->is_logged);
        View::share('current_user', $this->current_user);
        View::share('content', $this->content);
        View::share('storage', $this->storage);
        View::share('is_admin', $this->is_admin);



       //parent::__construct();
       //print "Конструктор класа SubClass\n";
   }

}
