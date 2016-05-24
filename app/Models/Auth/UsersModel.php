<?php
namespace App\Models\Auth;

use App\Models\BaseModel;
use DB;
use Exception;
use Config;

class UsersModel extends BaseModel
{
    static protected $conditions = [
        'id'           => ['type' => self::VAR_NUMERIC,  'required' => false],
        'password'     => ['type' => self::VAR_CHAR,     'required' => true],
        'email'        => ['type' => self::VAR_CHAR,     'required' => true],
        'last_login'   => ['type' => self::VAR_NUMERIC],
        'salt'         => ['type' => self::VAR_CHAR,     'required' => true],
        'first_name'   => ['type' => self::VAR_CHAR],
        'last_name'    => ['type' => self::VAR_CHAR],
        'is_confirmed' => ['type' => self::VAR_BOOL]
    ];

    const TABLE = 'users';

    public static function add($aData)
    {
        return self::insert($aData, self::TABLE);
    }

    public static function getByUsername($aUsername)
    {
        if (empty($aUsername))
            throw new Exception('Invalid username: '.$aUsername);

        $lSql = "SELECT * FROM ". self::TABLE.CRLF.
            "WHERE username = :username";

        return DB::select($lSql, [':username' => $aUsername]);
    }

    public static function getByEmail($aEmail)
    {
        if (empty($aEmail))
            throw new Exception('Invalid email: '.$aEmail);

        $lSql = "SELECT * FROM ". self::TABLE.CRLF.
            "WHERE email = :email";

        $lResult = DB::select($lSql, [':email' => $aEmail]);

        if (empty($lResult))
            return false;

        return $lResult[0];
    }

    public static function getByID($aId)
    {
        if (empty($aId) || !is_numeric($aId))
            throw new Exception('Invalid email: '.$aId);

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


    public static function getAll($aFilters = [])
    {
        $lLimit = Config::get('common.page_size');
        $lParams = [
            ':limit'  => $lLimit,
            ':offset' => ((isset($aFilters['page']) && $aFilters['page'] > 0) ? $lLimit * ($aFilters['page'] - 1) : 0)
        ];

        $lConditions = [];

        $lSql = "SELECT COUNT(id) as count".CRLF.
                "FROM ".self::TABLE.CRLF.
                ((empty($lConditions)) ? '' : 'WHERE '.implode(' AND ', $lConditions));

        $lResult['count'] = DB::select(DB::raw($lSql, $lParams));
        $lResult['count'] = (empty($lResult['count'][0]->count)) ? 0 : $lResult['count'][0]->count;

        $lSql = "SELECT * ".CRLF.
                "FROM ".self::TABLE.
                ((empty($lConditions)) ? '' : 'WHERE '.implode(' AND ', $lConditions)).CRLF.
                "ORDER BY id DESC".CRLF.
                "LIMIT :offset, :limit";

        $lResult['items'] = DB::select($lSql, $lParams);

        return $lResult;
    }
}
