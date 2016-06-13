<?php namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;

use App\Models\Article;
use App\Models\ArticlesCategories;
use App\Models\Category;
use App\Models\Comment;

use Exception;
use Request;

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
        //$this->template->scripts[] = '/'.$this->storage.'media/js/articles_manage.js';

        $lResult = view('pages.articles_manage', [
            'articles' => Article::paginate($this->page_size)
        ]);

        return $lResult;
    }

    public function edit($aId)
    {
        $lResult = view('pages.articles_add',[
            'article'            => Article::where('id', '=', $aId)->first(),
            'article_categories' => ArticlesCategories::where('article_id', '=', $aId)->get(),
            'categories'         => Category::all(),
            'edit_mode'          => true
        ]);

        return $lResult;
    }

    public function add()
    {

        $lResult = view('pages.articles_add', [
            'categories' => Category::all()
        ]);

        return $lResult;
    }

    public function index()
    {
        $lCategoryId = Request::input('category_id', null);

        if (!empty($lCategoryId) && is_numeric($lCategoryId)) {
            $lArticles = Article::where('is_published', '=', true)
                ->join('articles_categories', 'articles_categories.article_id', '=', 'articles.id')
                ->where('category_id', '=', $lCategoryId)
                ->paginate($this->page_size);
        }
        else
            $lArticles = Article::paginate($this->page_size);

        $lResult = view('pages.articles_index', [
            'articles' => $lArticles,
            'categories' => Category::all()
        ]);

        return $lResult;
    }

    public function details($aId)
    {
        return view('pages.articles_details', [
            'article'            => Article::where('id', '=', $aId)->with('articlesCategories')->first(),
            'article_categories' => ArticlesCategories::where('article_id', '=', $aId)->with('category')->get(),
            'comments'           => Comment::where('article_id', '=', $aId)->with('user')->paginate($this->page_size)
        ]);
    }

}
