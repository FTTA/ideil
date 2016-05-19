<?php namespace App;

class Status
{
    static public function success($aParams = [])
    {
        return ['status' => 'ok'] + (is_array($aParams) ? $aParams : []);
    }

    static public function error($aErrorCode = false)
    {
        return ['status' => 'error'] +
            (empty($aErrorCode) ? [] : ['code' => $aErrorCode]);
    }

    static public function success_json($aParams = [])
    {
        return self::to_json(
            ['status' => 'ok'] + (empty($aParams) ? [] : $aParams)
        );
    }

    static public function error_json($aErrorCode = false)
    {
        return self::to_json([
            'status' => 'error',
            'code' => $aErrorCode
                ? $aErrorCode
                : 'alerts.common.undefined'
            ]
        );
    }

    static public function to_json($aData)
    {
        return json_encode($aData, JSON_UNESCAPED_UNICODE);
    }
}