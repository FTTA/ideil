<?php namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;


use Exception;
use Request;


use App\Models\Articles;
use App\Models\Comment;

class CommentsController extends ParentController
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

    public function manage($aId)
    {
        $this->template->scripts[] = '/'.$this->storage.'media/js/comments_manage.js';
        $this->template->content_block = view('pages.comments_manage', [
            'article'   => Article::where('id', '=', $aId)->first(),
            'comments'  => CommentsModel::where('article_id', '=', $aId)->paginate($this->page_size)
        ]);
        return $this->template;
    }

}
