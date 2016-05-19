<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use App\AuthModule;
use Config;
use Session;
use View;

abstract class ParentController extends BaseController
{

	use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;


    function __construct()
    {
        if (AuthModule::isLogged()) {
            $this->current_user = AuthModule::getUserInfo();
            $this->is_logged = true;
        }
        else {
            $this->current_user = false;
            $this->is_logged = false;
        }

        AuthModule::accessGuard();

        $this->storage   = Config::get('common.storage');
        $this->content   = Config::get('common.content');
        $this->page_size = Config::get('common.page_size');

        $this->template = view('main_template', ['content_block' => 'success']);
        $this->template->styles = [
            ''.$this->storage.'/media/bootstrap/css/bootstrap.min.css',
            ''.$this->storage.'/media/css/style.css'
        ];

        $this->template->scripts = [
            '/'.$this->storage.'media/js/jquery-1.11.3.min.js',
            '/'.$this->storage.'media/js/sys_funcs.js',
            '/'.$this->storage.'media/js/submit_and_send.js',
            '/'.$this->storage.'media/js/common.js',



            //========================== jquery-validation-1.14.0
            '/'.$this->storage.'media/jquery-validation-1.14.0/jquery.validate.min.js',
            '/'.$this->storage.'media/jquery-validation-1.14.0/additional-methods.js',
            //==========================
        ];

        $this->template->header     = view('header');
        $this->template->menu_block = view('menu_block');
        $this->template->footer     = view('footer');

        View::share('is_logged', $this->is_logged);
        View::share('current_user', $this->current_user);
        View::share('content', $this->content);
        View::share('storage', $this->storage);



       //parent::__construct();
       //print "Конструктор класа SubClass\n";
   }

}
