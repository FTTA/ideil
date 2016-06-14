<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['text','user_id', 'date_creation', 'article_id'];
    public $timestamps = false;

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

}
