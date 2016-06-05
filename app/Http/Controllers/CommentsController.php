<?php namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;

use App\Models\CommentsModel;
use Exception;
use Request;


use App\Models\Articles;

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
        //$this->template->content_block = view('index_index', ['content' => 'test content']);
        //$this->template->content_block = view('pages.articles_index');



        $lFilters = [
            'page'       => Request::input('page', 1),
            'article_id' => $aId
        ];

        $lComments = CommentsModel::getAll($lFilters);

        $this->template->scripts[] = '/'.$this->storage.'media/js/comments_manage.js';
        $this->template->content_block = view('pages.comments_manage', [
            'article'   => Article::where('id', '=', $aId)->first(),
            'comments'  => $lComments['items'],
            'paginator' => new Paginator(
                $lComments['items'],
                $lComments['count'],
                $this->page_size,
                $lFilters['page'],
                ['path' => Request::url(), 'query' => $_GET]
            )
        ]);
        return $this->template;
    }

}
