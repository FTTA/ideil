<?php namespace App\Http\Controllers\Ajax;

use Illuminate\Support\Facades\Validator;
use Session;
use Auth;
use App\User;
use Request;
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
        $lData = Request::only('password', 'email');

        if (Auth::attempt(['email' => $lData['email'], 'password' => $lData['password']], true))
            return Status::success_json();

        return Status::error_json('Хибні дані');
    }

    public function signOut()
    {
        Auth::logout();
        return Status::success_json();
    }

    public function registration()
    {
        $lData = Request::only('password', 'email', 'password_confirm', 'name');

        $lFilters = [
            'name'             => 'required|max:255',
            'password'         => 'required|min:6',
            'password_confirm' => 'required|same:password',
            'email'            => 'required|email|max:255|unique:users',
        ];

        $lValidator = Validator::make($lData, $lFilters);

        if ($lValidator->fails()) {

            $lErrors = $lValidator->messages();

            $lPreparedErrors = implode(' ', $lErrors->all());

            return Status::error_json($lPreparedErrors);
        }

        User::create([
            'name' => $lData['name'],
            'email' => $lData['email'],
            'password' => bcrypt($lData['password']),
        ]);

        return Status::success_json();
    }
}
