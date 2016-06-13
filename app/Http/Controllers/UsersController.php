<?php namespace App\Http\Controllers;

use App\ImagesManipulator;
use App\User;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Request;

class UsersController extends ParentController
{
    public function users()
    {
        $lUsers = User::paginate($this->page_size);

        return view('pages.users_users', [
            'users' => $lUsers
        ]);
    }

    public function publicp($aUserId)
    {
        if (empty($aUserId) || !is_numeric($aUserId))
            throw new Exception('Invalid user ID');

        $lUser = User::where('id', '=', $aUserId)->first();

        if (empty($lUser))
            throw new Exception('Invalid user ID');

        $lMediaItems = $lUser->getMedia();

        return view('pages.users_public', [
            'user'       => $lUser,
            'user_image' => (!empty($lMediaItems[0])) ? $lMediaItems[0]->getUrl() : null
        ]);
    }

    public function profile()
    {
        $lMediaItems = $this->current_user->getMedia();

        return view('pages.users_profile', [
            'user_image' => (!empty($lMediaItems[0])) ? $lMediaItems[0]->getUrl() : null
        ]);
    }

    public function edit()
    {
        $lMediaItems = $this->current_user->getMedia();

        return view('pages.users_edit', [
            'user_image' => (!empty($lMediaItems[0])) ? $lMediaItems[0]->getUrl() : null
        ]);
    }
}
