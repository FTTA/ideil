<?php namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Exception;

use App\Models\Category;

class CategoriesController extends ParentController
{
    public function edit($aId)
    {
        return view('pages.categories_add', [
            'category'  => Category::where('id', '=', $aId)->first(),
            'edit_mode' => true
        ]);
    }

    public function add()
    {
        return view('pages.categories_add');
    }

    public function index()
    {
        return view('pages.categories_index', [
            'categories' => Category::all()
        ]);
    }
}
