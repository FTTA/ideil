<?php namespace App\Http\Controllers;
use App\ImagesManipulator;

class UsersController extends ParentController
{


    public function profile()
    {
        $this->template->content_block = view('pages.users_profile');
        return $this->template;
    }
/*
    public function publicPfoile()
    {

    }
*/

    public function edit()
    {
        $this->template->scripts[] = '/'.$this->storage.'media/js/file_uploader.js';
        $this->template->scripts[] = '/'.$this->storage.'media/js/users_edit.js';

        $lAvatar = new ImagesManipulator('App\Models\UsersImgModel');

        $lImage = $lAvatar->getByOwner($this->current_user->id);
        reset($lImage);
        $this->template->content_block = view('pages.users_edit', [
            'user_image' => current($lImage)
        ]);
        return $this->template;
    }
}
