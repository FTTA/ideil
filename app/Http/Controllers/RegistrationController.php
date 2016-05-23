<?php namespace App\Http\Controllers;
use App\AuthModule;

class RegistrationController extends ParentController
{
    public function index()
    {
        $this->template->scripts[] = '/'.$this->storage.'media/js/registration_index.js';
        $this->template->content_block = view('pages.registration_index');
        return $this->template;
    }

    public function confirm()
    {
        if (!empty($_GET['gf']) && AuthMOdule::confirmRegistration($_GET['gf']))
            $this->template->content_block = 'Профіль підтверджено успішно. Будь-ласка залогуйтеся.';
        else
            $this->template->content_block = 'Невірні данв. Процедуру підтвердження провалено.';

        return $this->template;
    }

    public function error()
    {
        $this->template->content_block = view('pages.registration_error', [
            'controller' => empty($_GET['controller']) ? '--' : $_GET['controller'],
            'action'     => empty($_GET['action']) ? '--' : $_GET['action']
        ]);

        return $this->template;
    }
}