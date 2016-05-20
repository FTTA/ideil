<?php namespace App\Http\Controllers\Ajax;

use Illuminate\Support\Facades\Validator;
use App\AuthModule;
use App\Models\ArticlesModel;
use App\Models\ArticlesCategoriesModel;
use App\Status;
use DB;

class ArticlesAjaxController extends ParentajaxController
{
    public function add()
    {
        $lArticleData = array_only($_POST, ['title', 'text']);

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

        if (!empty($_POST['categories'])) {
            $lCategories = $_POST['categories'];
            foreach ($lCategories as $lKey => $lVal) {
                if (empty($lVal['category_id']) || !is_numeric($lVal['category_id']))
                    die(Status::error_json('Invalid category :'.$lVal['category_id']));
            }
        }
        else
            $lCategories = null;

        $lArticleData['user_id']       = $this->current_user->id;
        $lArticleData['date_creation'] = date('Y-m-d H:i:s');

        try {
            DB::beginTransaction();

            $lId = ArticlesModel::add($lArticleData);

            if (!empty($lCategories)) {
                foreach ($lCategories as $lKey => $lVal)
                    $lCategories[$lKey]['article_id'] = $lId;

                ArticlesCategoriesModel::add($lCategories, $lId);
            }

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();

            die(Status::error_json($e));
        }

        die(Status::success_json());
    }

    public function published()
    {
        if (empty($_POST['article_id']) || !is_numeric($_POST['article_id']))
            die(Status::error_json('Invalid article ID'));

        $lData['is_published'] = empty($_POST['is_published']) ? false : true;

        ArticlesModel::edit($lData, $_POST['article_id']);
        die(Status::success_json());
    }

    public function edit()
    {
        $lData = array_only($_POST, ['title', 'text', 'article_id']);

        $lFilters = [
            'title'      => 'required|between:3,255',
            'article_id' => 'required|integer',
            'text'       => 'required|min:20'
        ];

        $lValidator = Validator::make($lData, $lFilters);

        if ($lValidator->fails()) {

            $lErrors = $lValidator->messages();

            $lPreparedErrors = implode(' ', $lErrors->all());

            die(Status::error_json($lPreparedErrors));
        }

        $lTemp = ArticlesModel::getByID($lData['article_id']);
        if (empty($lTemp))
            die(Status::error_json('Стаття не існує'));

        $lTemp = $lData['article_id'];
        unset($lData['article_id']);

        if (!empty($_POST['categories'])) {
            $lCategories = $_POST['categories'];
            foreach ($lCategories as $lKey => $lVal) {
                if (empty($lVal['category_id']) || !is_numeric($lVal['category_id']))
                    die(Status::error_json('Invalid category :'.$lVal['category_id']));

                $lCategories[$lKey]['article_id'] = $lTemp;
            }
        }
        else
            $lCategories = null;
/*
        echo '<pre>';
        var_dump($lCategories);
        die();*/

        try {
            DB::beginTransaction();

            ArticlesCategoriesModel::deleteByArticle($lTemp);

            if (!empty($lCategories))
                ArticlesCategoriesModel::add($lCategories);

            ArticlesModel::edit($lData, $lTemp);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();

            die(Status::error_json($e));
        }

        die(Status::success_json());
    }

    public function delete()
    {
        if (empty($_POST['article_id']) || !is_numeric($_POST['article_id']))
            die(Status::error_json('Invalid article ID'));

        $lTemp = CommentsModel::getAll([ 'article_id' => $_POST['article_id'] ]);
        if (!empty($lTemp['items']))
            die(Status::error_json('Видалення неможливе. У статті є залежний контент'));

        ArticlesModel::delete($_POST['article_id']);
        die(Status::success_json());
    }
}