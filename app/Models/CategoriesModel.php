<?php
namespace App\Models;

use App\Models\BaseModel;
use DB;
use Exception;

class CategoriesModel extends BaseModel
{
    static protected $conditions = [
        'id'            => ['type' => self::VAR_NUMERIC,  'required' => false],
        'user_id'       => ['type' => self::VAR_NUMERIC,  'required' => true],
        'article_id'    => ['type' => self::VAR_NUMERIC,  'required' => true],
        'text'          => ['type' => self::VAR_CHAR,     'required' => true],
        'date_creation' => ['type' => self::VAR_CHAR,     'required' => true],
        'is_blocked'    => ['type' => self::VAR_BOOL]
    ];

    const TABLE = 'comments';

    public static function add($aData)
    {
        return self::insert($aData, self::TABLE);
    }

    public static function getByID($aId)
    {
        if (empty($aId) || !is_numeric($aId))
            throw new Exception('Invalid ID: '.$aId);

        $lSql = "SELECT * FROM ". self::TABLE.CRLF.
            "WHERE id = :id";

        $lResult = DB::select($lSql, [':id' => $aId]);

        if (empty($lResult))
            return false;

        return $lResult[0];
    }

    public static function edit($aData, $aId)
    {
        if (empty($aId) || !is_numeric($aId))
            throw new Exception('Invalid ID: '.$aId);

        if (empty($aData) || !is_array($aData))
            throw new Exception('Invalid data for edit');

        self::update($aData, self::TABLE, ['id' => $aId]);
    }
}
