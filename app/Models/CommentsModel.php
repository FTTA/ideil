<?php
namespace App\Models;

use App\Models\BaseModel;
use DB;
use Exception;

class CommentsModel extends BaseModel
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

    public static function getAll($aFilters = [])
    {
        $lConditions = [];

        if (!empty($aFilters['article_id'])) {
            $lConditions[] = 'C.article_id = :article_id';
            $lParams[':article_id'] = $aFilters['article_id'];
        }

        $lSql = "SELECT count(id) as count ".CRLF.
                "FROM ".self::TABLE." C".CRLF.
                (empty($lConditions) ? '' : 'WHERE '.implode(' AND ', $lConditions));

        $lResult['count'] = DB::select($lSql, $lParams);
        $lResult['count'] = (empty($lResult['count'][0]->count)) ? 0 : $lResult['count'][0]->count;

        $lLimit = 1;
        $lParams[':limit']  = $lLimit;
        $lParams[':offset'] = (isset($aFilters['page']) && $aFilters['page'] > 0) ? $lParams[':limit'] * ($aFilters['page'] - 1) : 0;

        $lSql = "SELECT".CRLF.
                    "C.*,".CRLF.
                    "UM.file_name as user_avatar,".CRLF.
                    "U.email".CRLF.
                "FROM ".self::TABLE." C".CRLF.
                    "LEFT JOIN ".self::TABLE_USERS." U".CRLF.
                        "ON U.id = C.user_id".CRLF.
                    "LEFT JOIN ".self::TABLE_USERS_IMG." UM".CRLF.
                        "ON UM.user_id = C.user_id".CRLF.
                (empty($lConditions) ? '' : 'WHERE '.implode(' AND ', $lConditions)).CRLF.
                "ORDER BY id DESC".CRLF.
                "LIMIT :offset, :limit";

        $lResult['items'] = DB::select($lSql, $lParams);

        return $lResult;
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
