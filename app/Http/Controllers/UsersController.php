<?php namespace App\Http\Controllers;

use App\ImagesManipulator;
use App\Models\Auth\UsersModel;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class UsersController extends ParentController
{
    public function users()
    {
        $lFilters['page'] = (empty($_GET['page'])) ? 1 : $_GET['page'];

        $lUsers = UsersModel::getAll($lFilters);

        $lIds = [];

        // echo '<pre>';
        // var_dump($lUsers);
        // die();

        foreach ($lUsers['items'] as $lVal) {
            $lIds[] = $lVal->id;
        }

        $lAvatars = new ImagesManipulator('App\Models\UsersImgModel');
        $lImages  = $lAvatars->getByOwner($lIds);

        $this->template->content_block = view('pages.users_users', [
            'users'     => $lUsers['items'],
            'users_img' => $lImages,
            'paginator' => new Paginator(
                [],
                $lUsers['count'],
                $this->page_size,
                $lFilters['page'],
                ['path' => \Request::url(), 'query' => $_GET]
            )
        ]);

        return $this->template;
    }

    public function publicp($aUserId)
    {
        if (empty($aUserId) || !is_numeric($aUserId))
            throw new Exception('Invalid user ID');

        $this->template->content_block = view('pages.users_public', [
            'user' => UsersModel::getById($aUserId)
        ]);

        if (empty($this->template->content_block->user))
            throw new Exception('Invalid user ID');

        $lAvatar = new ImagesManipulator('App\Models\UsersImgModel');
        $lImage  = $lAvatar->getByOwner($aUserId);
        reset($lImage);

        $this->template->content_block->user_image = current($lImage);

        return $this->template;
    }

    public function profile()
    {
        $lAvatar = new ImagesManipulator('App\Models\UsersImgModel');
        $lImage = $lAvatar->getByOwner($this->current_user->id);
        reset($lImage);
        $this->template->content_block = view('pages.users_profile', [
            'user_image' => current($lImage)
        ]);
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
