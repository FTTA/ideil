<?php namespace App\Http\Controllers\Ajax;

use Illuminate\Support\Facades\Validator;
use App\AuthModule;

use Request;
use App\Status;
use DB;

use App\Models\Article;
use App\Models\Category;
use App\Models\ArticlesCategories;

class CategoriesAjaxController extends ParentajaxController
{
    public function add()
    {
        $lData['title'] = Request::input('title', null);

        $lValidator = Validator::make($lData, ['title' => 'required|between:3,255']);

        if ($lValidator->fails()) {

            $lErrors = $lValidator->messages();

            $lPreparedErrors = implode(' ', $lErrors->all());

            return Status::error_json($lPreparedErrors);
        }

        Category::create($lData);
        return Status::success_json();
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

            return Status::error_json($lPreparedErrors);
        }

        $lTemp = Category::where('id', '=', $aCategoryId)->first();
        if (empty($lTemp))
            return Status::error_json('Категіря не існує');

        Category::where('id', '=', $aCategoryId)
            ->update($lData);

        return Status::success_json();
    }

    public function delete($aCategoryId)
    {
        if (empty($aCategoryId) || !is_numeric($aCategoryId))
            return Status::error_json('Invalid article ID');

        $lTemp = ArticlesCategories::where('category_id', '=', $aCategoryId)->first();

        if (!empty($lTemp))
            return Status::error_json('Видалення неможливе. У категорії є залежний контент');

        Category::where('id', '=', $aCategoryId)
            ->delete();

        return Status::success_json();
    }
}
