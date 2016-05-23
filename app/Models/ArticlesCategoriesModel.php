<?php
namespace App\Models;

use App\Models\BaseModel;
use DB;
use Exception;

class ArticlesCategoriesModel extends BaseModel
{
    static protected $conditions = [
        'article_id'  => ['type' => self::VAR_NUMERIC,  'required' => true],
        'category_id' => ['type' => self::VAR_NUMERIC,  'required' => true]
    ];

    const TABLE = self::TABLE_ARTICLES_CATEGORIES;

    public static function add($aData)
    {
        return self::multiInsert($aData, self::TABLE);
    }

    public static function getByArticle($aId)
    {
        if (empty($aId) || !is_numeric($aId))
            throw new Exception('Invalid article ID: '.$aId);

        $lSql = "SELECT".CRLF.
                "AC.*,".CRLF.
                "C.title".CRLF.
            "FROM ". self::TABLE." AC".CRLF.
            "LEFT JOIN ".self::TABLE_CATEGORIES." C".CRLF.
                "ON C.id = AC.category_id".CRLF.
            "WHERE AC.article_id = :article_id";

        $lResult = DB::select($lSql, [':article_id' => $aId]);

        return $lResult;
    }

    public static function deleteByArticle($aId)
    {
        if (empty($aId) || !is_numeric($aId))
            throw new Exception('Invalid article ID: '.$aId);

        $lSql = "DELETE FROM ".self::TABLE.CRLF.
                "WHERE article_id = :article_id";

        return DB::delete($lSql, [':article_id' => $aId]);
    }
}
