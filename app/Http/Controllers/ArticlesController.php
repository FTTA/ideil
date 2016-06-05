<?php namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;


use App\Models\Comment;
use App\Models\CommentsModel;
use Exception;
use Request;


use App\Models\Article;
use App\Models\ArticlesCategories;
use App\Models\Category;

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
        $this->template->scripts[] = '/'.$this->storage.'media/js/articles_manage.js';

        $this->template->content_block = view('pages.articles_manage', [
            'articles'  => Article::paginate($this->page_size)
        ]);

        return $this->template;
    }

    public function edit($aId)
    {
        $this->template->scripts[] = '/'.$this->storage.'media/js/articles_add.js';
        $this->template->content_block = view('pages.articles_add',[
            'article'            => Article::where('id', '=', $aId)->first(),
            'article_categories' => ArticlesCategories::where('article_id', '=', $aId)->get(),
            'categories'         => Category::all(),
            'edit_mode'          => true
        ]);
        return $this->template;
    }

    public function add()
    {
        $this->template->scripts[] = '/'.$this->storage.'media/js/articles_add.js';
        $this->template->content_block = view('pages.articles_add', [
            'categories' => Category::all()
        ]);
        return $this->template;
    }

    public function index()
    {
        $lCategoryId = Request::input('category_id', null);

        $this->template->left_block = view('categories_block', [
            'categories' => Category::all()
        ]);

        if (!empty($lCategoryId) && is_numeric($lCategoryId)) {
            $lArticles = Article::where('is_published', '=', true)
                ->join('articles_categories', 'articles_categories.article_id', '=', 'articles.id')
                ->where('category_id', '=', $lCategoryId)
                ->paginate($this->page_size);
        }
        else
            $lArticles = Article::paginate($this->page_size);

        $this->template->content_block = view('pages.articles_index', [
            'articles' => $lArticles
        ]);

        return $this->template;
    }

    public function details($aId)
    {
        $this->template->scripts[] = '/'.$this->storage.'media/js/articles_details.js';
        $this->template->content_block = view('pages.articles_details', [
            'article'            => Article::where('id', '=', $aId)->with('articlesCategories')->first(),
            'article_categories' => ArticlesCategories::where('article_id', '=', $aId)->with('category')->get(),
            'comments'           => Comment::paginate($this->page_size)
        ]);
        return $this->template;
    }

}
