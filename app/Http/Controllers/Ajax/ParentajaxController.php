<?php namespace App\Http\Controllers\Ajax;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Config;
use App\AuthModule;
use Session;
use App\Status;

abstract class ParentajaxController extends BaseController
{

	use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;


    function __construct()
    {
        $this->storage = Config::get('common.storage');
        $this->content = Config::get('common.content');

        if (AuthModule::isLogged()) {
            $this->current_user = AuthModule::getUserInfo();
            $this->is_logged = true;
        }
        else {
            $this->current_user = false;
            $this->is_logged = false;
        }

        if(!AuthModule::accessGuard())
            die(Status::error_json('Необхідні права для доступу відсутні. Доступ заборонено.'));
//Session::all();
        /*echo '<pre>';
        var_dump(Session::all());
        die();*/

        /*
        $this->template = view('main_template', ['content_block' => 'success']);
        $this->template->styles = [
            ''.$this->storage.'/media/bootstrap/css/bootstrap.min.css',
            ''.$this->storage.'/media/css/style.css'
        ];

        $this->template->scripts = [
            '/'.$this->storage.'media/js/jquery-1.11.3.min.js',

            //========================== jquery-validation-1.14.0
            '/'.$this->storage.'media/jquery-validation-1.14.0/jquery.validate.min.js',
            '/'.$this->storage.'media/jquery-validation-1.14.0/additional-methods.js',
            //==========================
        ];

        $this->template->header     = view('header');
        $this->template->menu_block = view('menu_block');
        $this->template->footer     = view('footer');
*/
       //parent::__construct();
       //print "Конструктор класса SubClass\n";
   }

}
