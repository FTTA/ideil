<?php namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Exception;

use App\Models\Category;

class CategoriesController extends ParentController
{
    public function edit($aId)
    {
        $this->template->scripts[] = '/'.$this->storage.'media/js/categories_add.js';
        $this->template->content_block = view('pages.categories_add', [
            'category'  => Category::where('id', '=', $aId)->first(),
            'edit_mode' => true
        ]);
        return $this->template;
    }

    public function add()
    {
        $this->template->scripts[] = '/'.$this->storage.'media/js/categories_add.js';
        $this->template->content_block = view('pages.categories_add');
        return $this->template;
    }

    public function index()
    {
        $this->template->content_block = view('pages.categories_index', [
            'categories' => Category::all()
        ]);

        return $this->template;
    }
}
