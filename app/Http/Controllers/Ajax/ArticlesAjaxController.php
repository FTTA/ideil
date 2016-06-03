<?php namespace App\Http\Controllers\Ajax;

use Illuminate\Support\Facades\Validator;
use App\AuthModule;
use App\Models\ArticlesModel;

use App\Models\CommentsModel;
use App\Status;
use DB;
use Request;



use App\Models\ArticlesCategories;

class ArticlesAjaxController extends ParentajaxController
{
    public function add()
    {
        //$lArticleData = array_only($_POST, ['title', 'text']);
        $lArticleData = Request::only('title', 'text');

        $lFilters = [
            'title' => 'required|between:3,255',
            'text'  => 'required|min:20'
        ];

        $lValidator = Validator::make($lArticleData, $lFilters);

        if ($lValidator->fails()) {

            $lErrors = $lValidator->messages();

            $lPreparedErrors = implode(' ', $lErrors->all());

            die(Status::error_json($lPreparedErrors));
        }

        $lCategories = Request::input('categories', null);

        if (!empty($lCategories)) {
            foreach ($lCategories as $lKey => $lVal) {
                if (empty($lVal['category_id']) || !is_numeric($lVal['category_id']))
                    die(Status::error_json('Invalid category :'.$lVal['category_id']));
            }
        }

        $lArticleData['user_id']       = $this->current_user->id;
        $lArticleData['date_creation'] = date('Y-m-d H:i:s');

        try {
            DB::beginTransaction();

            $lId = ArticlesModel::add($lArticleData);

            if (!empty($lCategories)) {
                foreach ($lCategories as $lKey => $lVal)
                    $lCategories[$lKey]['article_id'] = $lId;

                ArticlesCategories::create($lCategories);
            }

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();

            die(Status::error_json($e));
        }

        die(Status::success_json());
    }

    public function published($aArticleId)
    {
        if (empty($aArticleId) || !is_numeric($aArticleId))
            die(Status::error_json('Invalid article ID'));

        $lData['is_published'] = Request::input('is_published', false);

        ArticlesModel::edit($lData, $aArticleId);
        die(Status::success_json());
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

            die(Status::error_json($lPreparedErrors));
        }

        $lTemp = ArticlesModel::getByID($aArticleId);
        if (empty($lTemp))
            die(Status::error_json('Стаття не існує'));

        $lCategories = Request::input('categories', null);

        if (!empty($lCategories)) {
            foreach ($lCategories as $lKey => $lVal) {
                if (empty($lVal['category_id']) || !is_numeric($lVal['category_id']))
                    die(Status::error_json('Invalid category :'.$lVal['category_id']));

                $lCategories[$lKey]['article_id'] = $aArticleId;
            }
        }

        try {
            DB::beginTransaction();

            ArticlesCategories::where('article_id', '=', $aArticleId)->delete();

            if (!empty($lCategories))
                ArticlesCategories::insert($lCategories);

            ArticlesModel::edit($lData, $aArticleId);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();

            die(Status::error_json($e));
        }

        die(Status::success_json());
    }

    public function delete($aArticleId)
    {
        if (empty($aArticleId) || !is_numeric($aArticleId))
            die(Status::error_json('Invalid article ID'));

        $lTemp = CommentsModel::getAll([ 'article_id' => $aArticleId ]);
        if (!empty($lTemp['items']))
            die(Status::error_json('Видалення неможливе. У статті є залежний контент'));
        try {
            DB::beginTransaction();

            ArticlesCategories::where('article_id', '=', $aArticleId)->delete();
            ArticlesModel::delete($aArticleId);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();

            die(Status::error_json($e));
        }

        die(Status::success_json());
    }
}