<?php namespace App\Http\Controllers\Ajax;

use Illuminate\Support\Facades\Validator;
use App\AuthModule;
use App\Status;
use App\ImagesManipulator;
use DB;
use Request;

class UsersAjaxController extends ParentajaxController
{
    public function changePass()
    {
        $lData = Request::only('password', 'password_new', 'password_confirm');

        if (empty($lData['password'])
            || empty($lData['password_new'])
            || empty($lData['password_confirm']))
            die(Status::error_json('Необхідні дані відсутні'));

        if ($lData['password_confirm'] !== $lData['password_new'])
            die(Status::error_json('Нові паролі не співпвдають'));

        if (!AuthModule::changePassword($lData['password'], $lData['password_confirm']))
            die(Status::error_json('Хибний пароль'));

        die(Status::success_json());
    }
    public function edit()
    {
        $lData        = Request::only('first_name', 'last_name');
        $lUserImg     = new ImagesManipulator('App\Models\UsersImgModel');
        $lImage       = [];
        $lDeleteImage = [];

        $lImage = Request::input('user_img', null);
        $lTemp  = Request::input('delete_user_img', null);

        if (!empty($lTemp)) {
            $lTemp = $lUserImg->getById($lTemp);
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
