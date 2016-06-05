<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticlesCategories extends Model
{
    protected $table = 'articles_categories';
    public $timestamps = false;

    public function category()
    {
        return $this->hasOne('App\Models\Category', 'id', 'category_id');
    }
}
