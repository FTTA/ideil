<?php namespace App\Http\Controllers;

use App\ImagesManipulator;
use App\User;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Request;

$lArticles = Article::where('is_published', '=', true)
                ->join('articles_categories', 'articles_categories.article_id', '=', 'articles.id')
                ->where('category_id', '=', $lCategoryId)
                ->paginate($this->page_size);

class UsersController extends ParentController
{
    public function users()
    {
        //$lFilters['page'] = Request::input('page', 1);

        //$lUsers = UsersModel::getAll($lFilters);

        $lUsers = User::paginate($this->page_size);
/*
        $lIds = [];

        foreach ($lUsers['items'] as $lVal) {
            $lIds[] = $lVal->id;
        }

        $lAvatars = new ImagesManipulator('App\Models\UsersImgModel');
        $lImages  = $lAvatars->getByOwner($lIds);*/

        $this->template->content_block = view('pages.users_users', [
            'users' => $lUsers
        ]);

        return $this->template;
    }

    public function publicp($aUserId)
    {
        if (empty($aUserId) || !is_numeric($aUserId))
            throw new Exception('Invalid user ID');

        $lUser = User::where('id', '=', $aUserId)->first();

        if (empty($lUser))
            throw new Exception('Invalid user ID');

        $lMediaItems = $lUser->getMedia();

        $this->template->content_block = view('pages.users_public', [
            'user'       => $lUser,
            'user_image' => $lMediaItems[0]->getUrl()
        ]);

        return $this->template;
    }

    public function profile()
    {
        $lMediaItems = $this->current_user->getMedia();

        $this->template->content_block = view('pages.users_profile', [
            'user_image' => $lMediaItems[0]->getUrl()
        ]);
        return $this->template;
    }

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
