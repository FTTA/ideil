<?php
namespace App\Models;
use DB;
use Exception;


define('CRLF', "\n");
class BaseModel
{
    //class own constants
    const
        TABLE_ARTICLES_CATEGORIES = 'articles_categories',
        TABLE_CATEGORIES          = 'categories',
        TABLE_USERS               = 'users',
        TABLE_USERS_IMG           = 'users_img';

    const INSERT = 'insert';
    const UPDATE = 'update';

    const
        VAR_NUMERIC  = 'numeric',
        VAR_CHAR     = 'char',
        VAR_BOOL     = 'bool';
    //const VAR_PASSWORD = 'password';

    static protected $conditions = [];
     /* Example of array:
     * [
     *   'id'    => ['type' => VAR_NUMERIC,  'required' => true],
     *   'email' => ['type' => VAR_CHAR,     'required' => true],
     *   'phone' => ['type' => VAR_NUMERIC,  'required' => false],
     *    ...
     *  ];
     */

    static public function fieldsGet()
    {
        return array_keys(static::$conditions);
    }

    static protected function toFloat($aNumber)
    {
        if (is_numeric($aNumber))
            return $aNumber;

        $lNewNumber = str_replace(',', '.', $aNumber);

        if (!is_numeric($lNewNumber))
            return false;
        return $lNewNumber;
    }

    static protected function fieldsValidation($aParams, $aConditions, $aValidateType, $aTable = false)
    {
        $lMessage = ($aTable) ? 'In table '.$aTable.'. ' : '';
        if ($aValidateType != self::INSERT && $aValidateType != self::UPDATE)
            throw new Exception($lMessage.'Invalid set validation mode');

        if (empty($aConditions) || empty($aParams))
            throw new Exception($lMessage.'Empty conditions or params');

        foreach ($aParams as $lField => $lValue) {
            if (!isset($aConditions[$lField]))
                throw new Exception($lMessage.'Not supported field: '.$lField);
        }

        foreach($aConditions as $lField => $lCondition) {
            if (!isset($aParams[$lField])) {
                if ($aValidateType == self::INSERT && !empty($lCondition['required']))
                    throw new Exception($lMessage.'Field is required: '.$lField);

                continue;
            }

            switch ($lCondition['type']) {
                case self::VAR_NUMERIC:
                    if (!is_numeric($aParams[$lField])) {
                        $lTemp = self::toFloat($aParams[$lField]);

                        if ($lTemp === false)
                            /*throw new Exception($lMessage.'Invalid number: '.
                                $lTemp.' in field: '.$lField);*/
                            abort(403, $lMessage.'Invalid number: '.$lTemp.' in field: '.$lField);
                    }
                    break;
                case self::VAR_CHAR:
                    /*if (!isset($aParams[$lField]))
                        throw new Exception($lMessage.'Invalid string: '.
                            $aParams[$lField].' in field: '.$lField);*/
                    break;
                case self::VAR_BOOL:
                    if ($aParams[$lField] != 0
                        && $aParams[$lField] != 1
                        && !is_bool($aParams[$lField])
                    )
                        throw new Exception($lMessage.'Invalid boolean: '.
                            $aParams[$lField].' in field: '.$lField);
                    break;
            }
        }
        return true;
    }

    static protected function insert($aFields, $aTable)
    {
        self::fieldsValidation($aFields, static::$conditions, self::INSERT);

        $lParamValues = [];
        foreach ($aFields as $lKey => $lVal) {
            if (static::$conditions[$lKey]['type'] == self::VAR_NUMERIC) {
                $lParamValues[':'.$lKey] = self::toFloat($lVal);
                continue;
            }
            $lParamValues[':'.$lKey] = $lVal;
        }

        $lFieldNames = array_keys($aFields);
        $lSql = "INSERT INTO ".$aTable." ".
            "(" . implode(', ', $lFieldNames) . ") ".
            "VALUES (:" . implode(', :', $lFieldNames) . ")";

        $lResult = DB::insert($lSql, $lParamValues);

        return (empty($lResult)) ? false : DB::getPdo()->lastInsertId();
    }

    static protected function multiInsert($aData, $aTable)
    {
        if (!is_array($aData))
            throw new Exception('Invalid data for multi insert');
        reset($aData);

        $lFieldNames   = array_keys(current($aData));
        $lInsertValues = [];
        $lParamValues  = [];
        $lCounter      = 0;

        foreach ($aData as $lItem) {
            self::fieldsValidation($lItem, static::$conditions, self::INSERT);

            $lInsertValues[$lCounter] = 'VALUES (';
            $lValues = [];
            foreach ($lItem as $lKey => $lVal) {
                $lValues[] = ':'.$lCounter.$lKey;

                $lParamValues[':'.$lCounter.$lKey] =
                    (static::$conditions[$lKey]['type'] == self::VAR_NUMERIC) ? self::toFloat($lVal) : $lVal;
            }

            $lInsertValues[$lCounter] .= implode(', ', $lValues).')';

            $lCounter++;
        }

        $lSql = "INSERT INTO ".$aTable." ".
            "(" . implode(', ', $lFieldNames) . ") ".
            implode(',', $lInsertValues);

        $lResult = DB::insert($lSql, $lParamValues);

        //return (empty($lResult)) ? false : DB::getPdo()->lastInsertId();
    }

    static protected function update($aData, $aTable, $aFilter)
    {
        if (empty($aFilter) || !is_array($aFilter))
            throw new Exception('Invalid filter params: '.print_r($aFilter));
        if (empty($aData) || !is_array($aData))
            throw new Exception('Invalid data for update: '.print_r($aData));

        if (!self::fieldsValidation(
            $aData, static::$conditions, self::UPDATE, $aTable
        ))
            throw new Exception('Invalid input fields');

        if (!self::fieldsValidation(
            $aFilter, static::$conditions, self::UPDATE, $aTable
        ))
            throw new Exception('Invalid input filter params');

        $lValues      = [];
        $lConditions  = [];
        $lParamValues = [];

        foreach ($aFilter as $lKey => $lVal) {
            $lParamValues[':'.$lKey] = $lVal;
            $lConditions[] = $lKey.' = '.':'.$lKey;
        }

        foreach ($aData as $lKey => $lVal) {
            if(isset($lParamValues[':'.$lKey]))
                throw new Exception('Warning! The field that is the as condition could not be updated.');

            $lValues[] = $lKey.' = :'.$lKey;
            if (static::$conditions[$lKey]['type'] == self::VAR_NUMERIC) {
                $lParamValues[':'.$lKey] = self::toFloat($lVal);
                continue;
            }
            $lParamValues[':'.$lKey] = $lVal;
        }

        $lSql = "UPDATE ".$aTable.CRLF.
                "SET ".implode(CRLF.", ", $lValues).CRLF.
                "WHERE ".implode(' AND ', $lConditions);

        return DB::update($lSql, $lParamValues);
    }
}
