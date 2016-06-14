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

        echo '<pre>';
        var_dump(bcrypt($lData['password']));
        echo '<br>';
        var_dump($this->current_user->password);
        die();

        if (bcrypt($lData['password']) !== $this->current_user->password)
            die(Status::error_json('Хибний пароль'));

        $this->current_user->update(['password' => bcrypt($lData['password_new'])]);

        die(Status::success_json());
    }
    public function edit()
    {
        $lData        = Request::only('name');
        $lUserImg     = new ImagesManipulator('App\Models\UsersImgModel');
        $lImage       = [];
        $lDeleteImage = [];

        $lImage = Request::input('user_img', null);
        $lDeleteImg  = Request::input('delete_user_img', null);

        try {
            DB::beginTransaction();

            if (!empty($lData))
                $this->current_user->update($lData);

            if (!empty($lDeleteImg)) {
                $this->current_user->clearMediaCollection('images');
            }

            if (!empty($lImage)) {
                reset($lImage);
                $lTemp = current($lImage);
                $this->current_user->clearMediaCollection();
                $this->current_user->addMedia($lTemp['image_path'])->toCollection('images');
            }

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e);
        }

        return Status::success_json();
    }
}
