<?php namespace App\Http\Controllers\Ajax;

use Illuminate\Support\Facades\Validator;
use App\AuthModule;
use App\Models\CategoriesModel;
use App\Models\CommentsModel;
use App\Status;
use DB;

class CategoriesAjaxController extends ParentajaxController
{
    public function add()
    {
        $lData = array_only($_POST, ['title']);

        $lValidator = Validator::make($lData, ['title' => 'required|between:3,255']);

        if ($lValidator->fails()) {

            $lErrors = $lValidator->messages();

            $lPreparedErrors = implode(' ', $lErrors->all());

            die(Status::error_json($lPreparedErrors));
        }

        ArticlesModel::add($lData);
        die(Status::success_json());
    }

    public function edit()
    {
        $lData = array_only($_POST, ['title']);

        $lFilters = [
            'title'      => 'required|between:3,255',
            'article_id' => 'required|integer',
            'text'       => 'required|min:20'
        ];

        $lValidator = Validator::make($lData, ['title' => 'required|between:3,255']);

        if ($lValidator->fails()) {

            $lErrors = $lValidator->messages();

            $lPreparedErrors = implode(' ', $lErrors->all());

            die(Status::error_json($lPreparedErrors));
        }

        $lTemp = ArticlesModel::getByID($lData['article_id']);
        if (empty($lTemp))
            die(Status::error_json('Категіря не існує'));

        $lArticleId = $lData['article_id'];
        unset($lData['article_id']);
        ArticlesModel::edit($lData, $lArticleId);

        die(Status::success_json());
    }

    public function delete()
    {
        if (empty($_POST['article_id']) || !is_numeric($_POST['article_id']))
            die(Status::error_json('Invalid article ID'));

        $lTemp = CommentsModel::getAll([ 'article_id' => $_POST['article_id'] ]);
        if (!empty($lTemp))
            die(Status::error_json('Видалення немождиве. У статті є залежний контент'));

        ArticlesModel::delete($_POST['article_id']);
        die(Status::success_json());
    }
}
