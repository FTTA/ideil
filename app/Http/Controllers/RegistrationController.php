<?php namespace App\Http\Controllers;
use App\AuthModule;
use Request;

class RegistrationController extends ParentController
{
    public function index()
    {
        return view('pages.registration_index');
    }
/*
    public function confirm()
    {
        if (!empty($_GET['gf']) && AuthMOdule::confirmRegistration($_GET['gf']))
            $this->template->content_block = 'Профіль підтверджено успішно. Будь-ласка залогуйтеся.';
        else
            $this->template->content_block = 'Невірні данв. Процедуру підтвердження провалено.';

        return $this->template;
    }*/

    public function error()
    {
        return view('pages.registration_error', [
            'controller' => Request::input('controller', '--'),
            'action'     => Request::input('action', '--')
        ]);
    }
}