<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';

    protected $fillable =  ['title', 'text', 'user_id', 'date_creation', 'is_published'];

    public $timestamps = false;

    public function articlesCategories()
    {
        return $this->hasMany('App\Models\ArticlesCategories');
    }

}
