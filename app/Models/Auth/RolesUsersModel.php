<?php
namespace App\Models\Auth;

use App\Models\BaseModel;
use DB;
use Exception;

class RolesUsersModel extends BaseModel
{
    static protected $conditions = [
        'user_id' => ['type' => self::VAR_NUMERIC,  'required' => false],
        'role_id' => ['type' => self::VAR_NUMERIC,  'required' => false]

    ];

    const TABLE = 'roles_users';

    public static function add($aData)
    {
        return self::insert($aData, self::TABLE);
    }

    public static function getByUser($aUserId)
    {
        if (empty($aUserId) || !is_numeric($aUserId))
            throw new Exception('Invalid user ID');

        $lSql = "SELECT * FROM ". self::TABLE.CRLF.
            "WHERE user_id = :user_id";

        $lResult = DB::select($lSql, [':user_id' => $aUserId]);

        return $lResult;
    }
}