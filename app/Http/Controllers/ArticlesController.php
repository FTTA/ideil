<?php namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\ArticlesCategoriesModel;
use App\Models\ArticlesModel;
use App\Models\CategoriesModel;
use App\Models\CommentsModel;
use Exception;
use Illuminate\Http\Request;

class ArticlesController extends ParentController
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
    public function manage()
    {
        $lFilters['page'] = (empty($_GET['page'])) ? 1 : $_GET['page'];

        $this->template->scripts[] = '/'.$this->storage.'media/js/articles_manage.js';
        $lArticles = ArticlesModel::getAll($lFilters);

        $this->template->content_block = view('pages.articles_manage', [
            'articles'  => $lArticles['items'],
            'paginator' => new Paginator(
                [],
                $lArticles['count'],
                $this->page_size,
                $lFilters['page'],
                ['path' => \Request::url(), 'query' => $_GET]
            )
        ]);

        return $this->template;
    }

    public function edit($aId)
    {
        //$this->template->content_block = view('index_index', ['content' => 'test content']);
        //$this->template->content_block = view('pages.articles_index');
        $this->template->scripts[] = '/'.$this->storage.'media/js/articles_add.js';
        $this->template->content_block = view('pages.articles_add',[
            'article'            => ArticlesModel::getById($aId),
            'article_categories' => ArticlesCategoriesModel::getByArticle($aId),
            'categories'         => CategoriesModel::getAll(),
            'edit_mode'          => true
        ]);
        return $this->template;
    }

    public function add()
    {
        //$this->template->content_block = view('index_index', ['content' => 'test content']);
        //$this->template->content_block = view('pages.articles_index');
        $this->template->scripts[] = '/'.$this->storage.'media/js/articles_add.js';
        $this->template->content_block = view('pages.articles_add', [
            'categories' => CategoriesModel::getAll()
        ]);
        return $this->template;
    }

    public function index()
    {
        //throw new Exception("Error Processing Request");

        $lFilters['page'] = (empty($_GET['page'])) ? 1 : $_GET['page'];


        //$this->template->content_block = view('index_index', ['content' => 'test content']);
        //$this->template->content_block = view('pages.articles_index');
        $lArticles = ArticlesModel::getAll($lFilters);

        $this->template->content_block = view('pages.articles_index', [
            'articles'  => $lArticles['items'],
            'paginator' => new Paginator(
                [],
                $lArticles['count'],
                $this->page_size,
                $lFilters['page'],
                ['path' => \Request::url(), 'query' => $_GET]
            )
        ]);

        return $this->template;
    }

    public function details($aId)
    {
        //$this->template->content_block = view('index_index', ['content' => 'test content']);
        //$this->template->content_block = view('pages.articles_index');



        $lFilters = [
            'page'       => (empty($_GET['page'])) ? 1 : $_GET['page'],
            'article_id' => $aId
        ];

        $lComments = CommentsModel::getAll($lFilters);

        $this->template->scripts[] = '/'.$this->storage.'media/js/articles_details.js';
        $this->template->content_block = view('pages.articles_details', [
            'article'   => ArticlesModel::getById($aId),
            'comments'  => $lComments['items'],
            'paginator' => new Paginator(
                $lComments['items'],
                $lComments['count'],
                $this->page_size,
                $lFilters['page'],
                ['path' => \Request::url(), 'query' => $_GET]
            )
        ]);
        return $this->template;
    }

}
