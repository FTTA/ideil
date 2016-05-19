<?php namespace App\Http\Controllers\Ajax;

use Illuminate\Support\Facades\Validator;
use App\AuthModule;
use App\Models\ArticlesModel;
use App\Models\CategoriesModel;
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

        CategoriesModel::add($lData);
        die(Status::success_json());
    }

    public function edit()
    {
        $lData = array_only($_POST, ['title', 'article_id']);

        $lFilters = [
            'title'      => 'required|between:3,255',
            'article_id' => 'required|integer',
        ];

        $lValidator = Validator::make($lData, $lFilters);

        if ($lValidator->fails()) {

            $lErrors = $lValidator->messages();

            $lPreparedErrors = implode(' ', $lErrors->all());

            die(Status::error_json($lPreparedErrors));
        }

        $lTemp = CategoriesModel::getByID($lData['article_id']);
        if (empty($lTemp))
            die(Status::error_json('Категіря не існує'));

        $lArticleId = $lData['article_id'];
        unset($lData['article_id']);
        CategoriesModel::edit($lData, $lArticleId);

        die(Status::success_json());
    }

    public function delete()
    {
        if (empty($_POST['category_id']) || !is_numeric($_POST['category_id']))
            die(Status::error_json('Invalid article ID'));
/*
        $lTemp = ArticlesModel::getAll([ 'category_id' => $_POST['category_id'] ]);
        if (!empty($lTemp))
            die(Status::error_json('Видалення неможливе. У категорії є залежний контент'));*/

        CategoriesModel::delete($_POST['category_id']);
        die(Status::success_json());
    }
}
