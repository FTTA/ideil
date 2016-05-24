<?php namespace App\Http\Controllers\Ajax;

use Illuminate\Support\Facades\Validator;
use App\AuthModule;
use App\Status;
use App\ImagesManipulator;
use DB;

class UsersAjaxController extends ParentajaxController
{
    public function changePass()
    {
        if (empty($_POST['password'])
            || empty($_POST['password_new'])
            || empty($_POST['password_confirm']))
            die(Status::error_json('Необхідні дані відсутні'));

        if ($_POST['password_confirm'] !== $_POST['password_new'])
            die(Status::error_json('Нові паролі не співпвдають'));

        if (!AuthModule::changePassword($_POST['password'], $_POST['password_confirm']))
            die(Status::error_json('Хибний пароль'));

        die(Status::success_json());
    }
    public function edit()
    {
        $lData        = array_only($_POST, ['first_name', 'last_name']);
        $lUserImg     = new ImagesManipulator('App\Models\UsersImgModel');
        $lImage       = [];
        $lDeleteImage = [];

        if (!empty($_POST['user_img']))
            $lImage = $_POST['user_img'];

        if (!empty($_POST['delete_user_img'])) {
            $lTemp = $lUserImg->getById($_POST['delete_user_img']);
            reset($lTemp);
            $lTemp = current($lTemp);
            if (!empty($lTemp->user_id) && $lTemp->user_id == $this->current_user->id)
                $lDeleteImage[] = $lTemp->id;
        }

        if (!empty($lImage)) {
            $lTemp = $lUserImg->getByOwner($this->current_user->id);
            foreach ($lTemp as $lVal)
                $lDeleteImage[] = $lVal->id;
        }
/*
        var_dump($lDeleteImage);
        die();*/
        try {
            DB::beginTransaction();

            if (!empty($lData))
                AuthModule::edit($lData);

            if (!empty($lDeleteImage))
                $lUserImg->delete($this->content['users'], $lDeleteImage);

            if (!empty($lImage)) {
                reset($lImage);
                $lTemp = current($lImage);
                $lTemp['user_id'] = $this->current_user->id;
                $lUserImg->add($this->content['users'], $lTemp);
            }

            $lUserImg->commit();
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            $lUserImg->rollback();
            throw new Exception($e);
        }

        die(Status::success_json());
    }
}



