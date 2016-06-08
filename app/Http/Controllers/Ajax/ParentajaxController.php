<?php namespace App\Http\Controllers\Ajax;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Config;

use Gate;
use Auth;
use Session;
use App\Status;

abstract class ParentajaxController extends BaseController
{

	use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;


    function __construct()
    {
        $this->storage = Config::get('common.storage');
        $this->content = Config::get('common.content');

        if (Auth::check()) {
            $this->current_user = Auth::user();
            $this->is_logged = true;
        }
        else {
            $this->current_user = false;
            $this->is_logged = false;
        };

        if (!Gate::allows('controller-access', \Route::currentRouteAction())) {
            die(Status::error_json('Необхідні права для доступу відсутні. Доступ заборонено.'));
        }

       //parent::__construct();
       //print "Конструктор класса SubClass\n";
   }

}
