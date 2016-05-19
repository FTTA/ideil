<?php namespace App\Models;

use Exception;
use App\Models\BaseModel;
use DB;

class UsersImgModel extends BaseModel
{
    static protected $conditions = [
        'id'          => ['type' => self::VAR_NUMERIC, 'required' => false],
        'user_id'     => ['type' => self::VAR_NUMERIC, 'required' => true],
        'image_name'  => ['type' => self::VAR_CHAR],
        'file_name'   => ['type' => self::VAR_CHAR,    'required' => true],
        'description' => ['type' => self::VAR_CHAR],
    ];

    const TABLE = self::TABLE_USERS_IMG;

    public static function add($aData)
    {
        return self::insert($aData, self::TABLE);
    }

    public static function edit($aData, $aId)
    {
        if (empty($aId) || !is_numeric($aId))
            throw new Exception('Invalid ID: '.$aId);

        if (empty($aData) || !is_array($aData))
            throw new Exception('Invalid data for edit');

        self::update($aData, self::TABLE, ['id' => $aId]);
    }

    public static function delete($aId)
    {
        if (empty($aId))
            throw new Exception('Category img ID is empty');

        if (!is_array($aId))
            $aId = [$aId];

        $n = 0;
        foreach ($aId as $lVal) {
            if (!is_numeric($lVal))
                throw new Exception('Invalid category img ID');

            $lConditions[] = 'id = :id'.$n;
            $lParamValues[':id'.$n] = $lVal;
            $n++;
        }

        $lSql = "DELETE FROM ". self::TABLE.CRLF.
            "WHERE ".implode(' OR ', $lConditions);

        return DB::delete($lSql, $lParamValues);
    }

    public static function getByOwner($aId)
    {
        if (empty($aId))
            throw new Exception('Invalid employee ID');

        if (!is_array($aId))
            $aId = [$aId];

        $lConditions = [];
        $lParams     = [];
        $lCounter    = 0;

        foreach ($aId as $lValue) {
            if (!is_numeric($lValue))
                throw new Exception('Invalid employee ID: '.$aId);

            $lConditions[] = 'user_id = :user_id'.$lCounter;
            $lParams[':user_id'.$lCounter] = $lValue;
            $lCounter++;
        }

        $lSql = "SELECT * FROM ". self::TABLE.CRLF.
            "WHERE ".(implode(' OR ', $lConditions));

        return DB::select($lSql, $lParams);
    }


    public static function getById($aID)
    {
        if (empty($aID))
            throw new Exception('Invalid category img ID');

        if (!is_array($aID))
            $aID = [$aID];

        $lConditions = [];
        $lParams     = [];
        $lCounter    = 0;

        foreach ($aID as $lValue) {
            if (!is_numeric($lValue))
                throw new Exception('Invalid employee ID: '.$aID);

            $lConditions[] = 'id = :id'.$lCounter;
            $lParams[':id'.$lCounter] = $lValue;
            $lCounter++;
        }

        $lSql = "SELECT * FROM ". self::TABLE.CRLF.
            "WHERE ".(implode(' OR ', $lConditions));

        return DB::select($lSql, $lParams);
    }

    public static function getByFileName()
    {

    }
/*
    public static function getAll()
    {
        $lSql = "SELECT * FROM ". self::TABLE;

        return DB::query(Database::SELECT, $lSql)
            ->execute()
            ->as_array();
    }*/
}
