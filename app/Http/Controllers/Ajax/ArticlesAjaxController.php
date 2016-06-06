<?php namespace App\Http\Controllers\Ajax;

use Illuminate\Support\Facades\Validator;
use App\AuthModule;

use App\Status;
use DB;
use Request;

use App\Models\Article;
use App\Models\ArticlesCategories;
use App\Models\Comment;

class ArticlesAjaxController extends ParentajaxController
{
    public function add()
    {
        $lArticleData = Request::only('title', 'text');

        $lFilters = [
            'title' => 'required|between:3,255',
            'text'  => 'required|min:20'
        ];

        $lValidator = Validator::make($lArticleData, $lFilters);

        if ($lValidator->fails()) {

            $lErrors = $lValidator->messages();

            $lPreparedErrors = implode(' ', $lErrors->all());

            return Status::error_json($lPreparedErrors);
        }

        $lCategories = Request::input('categories', null);

        if (!empty($lCategories)) {
            foreach ($lCategories as $lKey => $lVal) {
                if (empty($lVal['category_id']) || !is_numeric($lVal['category_id']))
                    return Status::error_json('Invalid category :'.$lVal['category_id']);
            }
        }

        $lArticleData['user_id']       = $this->current_user->id;
        $lArticleData['date_creation'] = date('Y-m-d H:i:s');

        try {
            DB::beginTransaction();

            $lArticle = Article::create($lArticleData);

            if (!empty($lCategories)) {
                foreach ($lCategories as $lKey => $lVal)
                    $lCategories[$lKey]['article_id'] = $lArticle->id;

                ArticlesCategories::insert($lCategories);
            }

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();

            die(Status::error_json($e));
        }

        return Status::success_json();
    }

    public function published($aArticleId)
    {
        if (empty($aArticleId) || !is_numeric($aArticleId))
            return Status::error_json('Invalid article ID');

        $lData['is_published'] = Request::input('is_published', false);

        Article::where('id', '=', $aArticleId)
            ->update($lData);
        return Status::success_json();
    }

    public function edit($aArticleId)
    {
        $lData = Request::only('title', 'text');

        $lFilters = [
            'title' => 'required|between:3,255',
            'text'  => 'required|min:20'
        ];

        $lValidator = Validator::make($lData, $lFilters);

        if ($lValidator->fails()) {

            $lErrors = $lValidator->messages();

            $lPreparedErrors = implode(' ', $lErrors->all());

            return Status::error_json($lPreparedErrors);
        }

        $lTemp = Article::where('id', '=', $aArticleId)->first();

        if (empty($lTemp))
            die(Status::error_json('Стаття не існує'));

        $lCategories = Request::input('categories', null);

        if (!empty($lCategories)) {
            foreach ($lCategories as $lKey => $lVal) {
                if (empty($lVal['category_id']) || !is_numeric($lVal['category_id']))
                    return Status::error_json('Invalid category :'.$lVal['category_id']);

                $lCategories[$lKey]['article_id'] = $aArticleId;
            }
        }

        try {
            DB::beginTransaction();

            ArticlesCategories::where('article_id', '=', $aArticleId)->delete();

            if (!empty($lCategories))
                ArticlesCategories::insert($lCategories);

            Article::where('id', '=', $aArticleId)
                ->update($lData);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();

            die(Status::error_json($e));
        }

        return Status::success_json();
    }

    public function delete($aArticleId)
    {
        if (empty($aArticleId) || !is_numeric($aArticleId))
            die(Status::error_json('Invalid article ID'));

        if (Comment::where('article_id', '=', $aArticleId)->count() > 0)
            die(Status::error_json('Видалення неможливе. У статті є залежний контент'));
        try {
            DB::beginTransaction();

            ArticlesCategories::where('article_id', '=', $aArticleId)->delete();
            Article::where('id', '=', $aArticleId)->delete();

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();

            die(Status::error_json($e));
        }

        return Status::success_json();
    }
}
