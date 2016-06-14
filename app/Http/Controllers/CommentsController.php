<?php namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;

use Exception;
use Request;

use App\Models\Article;
use App\Models\Comment;

class CommentsController extends ParentController
{
    public function manage($aId)
    {
        return view('pages.comments_manage', [
            'article'  => Article::where('id', '=', $aId)->first(),
            'comments' => Comment::where('article_id', '=', $aId)->with('user')->paginate($this->page_size)
        ]);
    }
}
