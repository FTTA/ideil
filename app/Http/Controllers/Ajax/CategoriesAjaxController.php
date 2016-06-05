<?php namespace App\Http\Controllers\Ajax;

use Illuminate\Support\Facades\Validator;
use App\AuthModule;

use Request;
use App\Status;
use DB;

use App\Models\Article;
use App\Models\Category;

class CategoriesAjaxController extends ParentajaxController
{
    public function add()
    {
        $lData['title'] = Request::input('title', null);

        $lValidator = Validator::make($lData, ['title' => 'required|between:3,255']);

        if ($lValidator->fails()) {

            $lErrors = $lValidator->messages();

            $lPreparedErrors = implode(' ', $lErrors->all());

            die(Status::error_json($lPreparedErrors));
        }

        Category::create($lData);
        die(Status::success_json());
    }

    public function edit($aCategoryId)
    {
        $lData['title'] = Request::input('title', null);

        $lFilters = [
            'title' => 'required|between:3,255'
        ];

        $lValidator = Validator::make($lData, $lFilters);

        if ($lValidator->fails()) {

            $lErrors = $lValidator->messages();

            $lPreparedErrors = implode(' ', $lErrors->all());

            die(Status::error_json($lPreparedErrors));
        }

        $lTemp = Category::where('id', '=', $aCategoryId)->first();
        if (empty($lTemp))
            die(Status::error_json('Категіря не існує'));

        CategoriesModel::where('id', '=', $aCategoryId)
            ->update($lData);

        die(Status::success_json());
    }

    public function delete($aCategoryId)
    {
        if (empty($aCategoryId) || !is_numeric($aCategoryId))
            die(Status::error_json('Invalid article ID'));

        $lTemp = Article::where('id', '=', $aArticleId)->first()

        if (!empty($lTemp['items']))
            die(Status::error_json('Видалення неможливе. У категорії є залежний контент'));

        CategoriesModel::where('id', '=', $aCategoryId)
            ->delete();

        die(Status::success_json());
    }
}
