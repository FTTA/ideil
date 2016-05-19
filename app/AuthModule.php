<?php namespace App;

use DB;
use Exception;
use App\Models\Auth\UsersModel;
use App\Models\Auth\RolesUsersModel;
use Session;

class AuthModule
{
    const VERSION = '2.1.0';

    const SALT = '1n3B4f5';

    const UR_GUEST   = 'guest';
    const UR_USER    = 3;
    const UR_MANAGER = 2;
    const UR_ADMIN   = 1;

    /*const CR_TRANSPORT  = 'transport';
    const CR_CARGO      = 'cargo';
    const CR_EXPEDITION = 'expedition';*/

    static protected $instance = NULL;

    static protected $acces_table = [

        'ArticlesController' => [
            'roles'   => [self::UR_ADMIN => true],
            'actions' => [
                'add'     => [],
                'details' => ['all_user' => true],
                'edit'    => [],
                'index'   => ['all_user' => true],
                'manage'  => []
            ]
        ],

        'CommentsController' => [
            'roles'   => [self::UR_ADMIN => true],
            'actions' => [
                'manage'  => []
            ]
        ],

        'FileUploaderController' => [
            'roles'   => ['all_user' => true, self::UR_GUEST => false],
            'actions' => [
                'upload'  => []
            ]
        ],

        'RegistrationController' => [
            'roles'   => [self::UR_GUEST => true],
            'actions' => [
                'index'   => [],
                'confirm' => []
            ]
        ],

        'UsersController' => [
            'roles'   => ['all_user' => true, self::UR_GUEST => false],
            'actions' => [
                'profile' => [],
                'edit'    => []
            ]
        ],



        'ArticlesAjaxController' => [
            'roles'   => [self::UR_ADMIN => true],
            'actions' => [
                'add'       => [],
                'edit'      => [],
                'published' => [],
                'delete'    => []
            ]
        ],

        'CommentsAjaxController' => [
            'roles'   => [self::UR_ADMIN => true],
            'actions' => [
                'add'      => ['all_user' => true, self::UR_GUEST => false],
                'blocking' => []
            ]
        ],

        'GeneralAjaxController' => [
            'roles'   => [self::UR_GUEST => true],
            'actions' => [
                'confirm' => [],
                'signIn'  => [],
                'signOut' => [self::UR_GUEST => true]
            ]
        ],

        'UsersAjaxController' => [
            'roles'   => [self::UR_GUEST => false],
            'actions' => [
                'changePass' => [],
                'edit'       => []
            ]
        ]
    ];

    static public function instance()
    {
        if (!self::$instance)
            self::$instance = new self();
        return self::$instance;
    }

    static public function addUser($aUserData)
    {
        if(empty($aUserData['email']))
            throw new Exception('Invalid email');

        if(empty($aUserData['username']))
            throw new Exception('Invalid username');

        if(empty($aUserData['password']))
            throw new Exception('Invalid password');

        if(empty($aUserData['password_confirm'])
            || $aUserData['password_confirm'] !== $aUserData['password']
        )
            throw new Exception('Invalid passwords mismatch');

        unset($aUserData['password_confirm']);

        $aUserData['salt']     = self::generatePassword(rand(5, 10));
        $aUserData['password'] = hash('sha256', self::SALT.$aUserData['password'].$aUserData['salt']);


        //$lDB = Database::instance();
        try {
            DB::beginTransaction();
            $lUserId = UsersModel::add($aUserData);

            RolesUsersModel::add(['user_id' => $lUserId, 'role_id' => self::UR_USER]);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e);
        }

        self::sendEmailConfirmation(UsersModel::getByEmail($aUserData['email']));

        return true;
    }

    static public function logIn($aEmail, $aPass, $aRestoreMode = false)
    {
        session_start();
        $lUser = UsersModel::getByEmail($aEmail);

        if (!$lUser)
            return false;

        if ($aRestoreMode)
            $lPassword = $aPass;
        else
            $lPassword = hash('sha256', self::SALT.$aPass.$lUser->salt);

        if ($lUser->password !== $lPassword)
            return false;

        $lUserRoles = RolesUsersModel::getByUser($lUser->id);

        unset($lUser->password);
        unset($lUser->salt);

        $lUser->roles = $lUserRoles; //get_object_vars($lUserRoles);

        Session::put('user_data', $lUser);
        Session::put('version', self::VERSION);
        Session::save();

        return true;
    }

    static public function getUserInfo()
    {
        if (!self::isLogged())
            return false;

        $lUserData = Session::get('user_data', false);
        $lUserData = UsersModel::getByID($lUserData->id);
        $lUserData->roles = RolesUsersModel::getByUser($lUserData->id);

        return $lUserData;
    }

    static public function isLogged()
    {
        $lVersion = Session::get('version', false);
        $lResult  = Session::get('user_data', false);

        if ($lResult && (!$lVersion || ($lVersion !== self::VERSION))) {
            $lResult = false;
            self::logOut();
        }

        return !empty($lResult);
    }

    public static function edit($aData)
    {
        $lUserData = self::getUserInfo();

        if (!$lUserData)
            throw new Exception('Invalid user');

        UsersModel::edit($aData, $lUserData->id);
    }

    public static function changePassword($aPasswordOld, $aPasswordNew)
    {
        if (empty($aPasswordOld) || empty($aPasswordNew))
            return false;

        $lUserData = self::getUserInfo();

        if (!$lUserData)
            return false;

        $lUserData = UsersModel::getByID($lUserData->id);

        if ($lUserData->password !== hash('sha256', self::SALT.$aPasswordOld.$lUserData->salt))
            return false;

        $lData = ['salt' => self::generatePassword(rand(5, 10))];
        $lData['password'] = hash('sha256', self::SALT.$aPasswordNew.$lData['salt']);

        UsersModel::edit($lData, $lUserData->id);

        return true;
    }

/*
    static public function renewSession($aNewPassword = false)
    {
        $lUser = self::getUserInfo();

        if (empty($lUser));
            return false;

        $lUser = Model_Auth_Users::getByEmail($lUser['email']);

        Session::put('user_data', $lUser);

        return true;
    }*/

    static public function logOut()
    {
        Session::put('user_data', false);
        Session::save();
    }

    static public function accessGuard(/*$aControllerName, $aActionName*/)
    {
        $lNeedCheck = [];
        if (!AuthModule::isLogged())
            $lNeedCheck[] = ['role_id' => self::UR_GUEST, 'type' => 'user'];
        else
        {
            $lUser      = AuthModule::getUserInfo();
            //$lCompany   = AuthModule::getCompanyInfo();


            foreach ($lUser->roles as $lRole) {
                $lNeedCheck[] = ['role_id' => $lRole->role_id, 'type' => 'user'];
            }
            //$lNeedCheck = ['user' => $lUser['role_id'], 'company' => $lCompany['activity_type']];
        }

        $aControllerName = explode('\\',  \Route::currentRouteAction());
        $aControllerName = explode('@', end($aControllerName));

        $aActionName     = $aControllerName[1];
        $aControllerName = $aControllerName[0];

        if (!isset(static::$acces_table[$aControllerName])
            || !isset(static::$acces_table[$aControllerName]['actions'][$aActionName])
        )
            throw new Exception('Error Processing Request '.$aControllerName.'/'.$aActionName);

        $lActions = static::$acces_table[$aControllerName]['actions'];
        $lRoles   = static::$acces_table[$aControllerName]['roles'];

        $lPermission = [];

        foreach ($lNeedCheck as $lRole)
        {
            if (isset($lActions[$aActionName][$lRole['role_id']]))
            {
                $lPermission[] = $lActions[$aActionName][$lRole['role_id']];
                continue;
            }

            if (isset($lActions[$aActionName]['all_'.$lRole['type']]))
            {
                $lPermission[] = $lActions[$aActionName]['all_'.$lRole['type']];
                continue;
            }

            if (isset($lRoles[$lRole['role_id']]))
            {
                $lPermission[] = $lRoles[$lRole['role_id']];
                continue;
            }

            if (isset($lRoles['all_'.$lRole['type']]))
            {
                $lPermission[] = $lRoles['all_'.$lRole['type']];
                continue;
            }

            switch($lRole['type'])
            {
                case 'user': $lPermission[] = false;
                    break;
                case 'company': $lPermission[] = true;
                    break;
                default : false;
            }
        }

        $lResult = true;

        foreach($lPermission as $lValue)
        {
            $lResult = $lResult && $lValue;
        }

        return $lResult;
    }

    static private function sendEmailConfirmation($aUser) {

        $lCode = md5($aUser->email.$aUser->salt);
        $lLink = 'http://'.$_SERVER['HTTP_HOST'].'/registration/confirm?gf='.
            md5($aUser->email.$aUser->salt).
            $aUser->id.
            strtolower(self::generatePassword(3));

        $lSubject = 'Confirmation email';
        $lBody    = 'To confirm registration go into <a href="'.$lLink.'">'.$lLink.'</a>';
        $lHeaders = "MIME-Version: 1.0 \r\n".
            "Content-type:text/html;charset=UTF-8 \r\n".
            "From: New-Project <".'New-Project'.">\r\n";

        mail($aUser->email, $lSubject, $lBody, $lHeaders);
    }

    static public function confirmRegistration($aCode) {
        $lHashCode = substr($aCode, 0, 32);
        $lUserId   = substr($aCode, 32, strlen($aCode) - 35);

        $lUser = UsersModel::getByID($lUserId);

        if (empty($lUser))
            throw new Exception('Wrong user ID');

        if ($lUser->is_confirmed)
            return true;

        if ($lHashCode = md5($lUser->email.$lUser->salt)) {
            UsersModel::edit(['is_confirmed' => true], $lUserId);
            return true;
        }

        return false;
    }

    static public function generatePassword($aLength)
    {
        $lChars = ['a','b','c','d','e','f',
            'g','h','i','j','k','l',
            'm','n','o','p','q','r','s',
            't','u','v','w','x','y','z',
            'A','B','C','D','E','F',
            'G','H','I','J','K','L',
            'M','N','O','P','Q','R','S',
            'T','U','V','W','X','Y','Z',
            '1','2','3','4','5','6',
            '7','8','9','0'
        ];
        $n = count($lChars)-1;
        $lResult = '';
        while ($aLength--)
            $lResult.=$lChars[rand(0, $n)];
        return $lResult;
    }
}
