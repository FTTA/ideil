<?php 
namespace App\Models;

use App\Models;

class Model_Auth_RolesUsers extends Model_Base
{
    static protected $conditions = [
        'id'          => ['type' => self::VAR_NUMERIC,  'required' => false],
        'name'        => ['type' => self::VAR_CHAR,     'required' => true],
        'description' => ['type' => self::VAR_CHAR,],

    ];

    const TABLE = 'roles_users';

    public static function getAll()
    {
        $lSql = "SELECT * FROM ". self::TABLE;

        return DB::query(Database::SELECT, $lSql)
            ->execute()
            ->as_array();
    }
}