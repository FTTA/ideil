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

    public function edit($aCategoryId)
    {
        $lData = array_only($_POST, ['title']);

        $lFilters = [
            'title' => 'required|between:3,255'
        ];

        $lValidator = Validator::make($lData, $lFilters);

        if ($lValidator->fails()) {

            $lErrors = $lValidator->messages();

            $lPreparedErrors = implode(' ', $lErrors->all());

            die(Status::error_json($lPreparedErrors));
        }

        $lTemp = CategoriesModel::getByID($aCategoryId);
        if (empty($lTemp))
            die(Status::error_json('Категіря не існує'));

        CategoriesModel::edit($lData, $aCategoryId);

        die(Status::success_json());
    }

    public function delete($aCategoryId)
    {
        if (empty($aCategoryId) || !is_numeric($aCategoryId))
            die(Status::error_json('Invalid article ID'));

        $lTemp = ArticlesModel::getAll(['category_id' => $aCategoryId]);
        if (!empty($lTemp['items']))
            die(Status::error_json('Видалення неможливе. У категорії є залежний контент'));

        CategoriesModel::delete($aCategoryId);
        die(Status::success_json());
    }
}
