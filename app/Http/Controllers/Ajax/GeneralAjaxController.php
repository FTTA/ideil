<?php namespace App\Http\Controllers\Ajax;

use Illuminate\Support\Facades\Validator;
use Session;
use App\AuthModule;
use App\Status;

class GeneralAjaxController extends ParentajaxController
{

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*
    public function __construct()
    {
        $this->middleware('auth');
    }*/

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */

    public function signIn()
    {
        $lData = array_only($_POST['sign_in'], ['password', 'email']);
        if (AuthModule::logIn($lData['email'], $lData['password']))
            die(Status::success_json());

        die(Status::error_json('Хибні дані'));
    }

    public function signOut()
    {
        AuthModule::logOut();
        die(Status::success_json());
    }

    public function registration()
    {

        $lData = array_only($_POST['user'], ['password', 'email', 'password_confirm', 'username']);

        $lFilters = [
            'password'         => 'required',
            'password_confirm' => 'required|same:password',
            'email'            => 'required|email',
            'username'         => 'required'
        ];

        $lValidator = Validator::make($lData, $lFilters);

        if ($lValidator->fails()) {

            $lErrors = $lValidator->messages();

            $lPreparedErrors = implode(' ', $lErrors->all());

            die(Status::error_json($lPreparedErrors));
        }

        AuthModule::addUser($lData);

        die(Status::success_json());
    }
}
