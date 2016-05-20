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

    const TABLE = 'articles_categories';

    public static function add($aData)
    {
        return self::multiInsert($aData, self::TABLE);
    }

    public static function getByArticle($aId)
    {
        if (empty($aId) || !is_numeric($aId))
            throw new Exception('Invalid article ID: '.$aId);

        $lSql = "SELECT * FROM ". self::TABLE.CRLF.
            "WHERE article_id = :article_id";

        $lResult = DB::select($lSql, [':article_id' => $aId]);

        if (empty($lResult))
            return false;

        return $lResult[0];
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
