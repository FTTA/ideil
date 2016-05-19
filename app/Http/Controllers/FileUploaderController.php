<?php namespace App\Http\Controllers;
use Exception;

class FileUploaderController extends ParentController
{
    public function upload()
    {
        if (empty($_FILES['files_to_load']))
            throw new Exception('Empty data');

        $lFile = $_FILES['files_to_load'];

        if (!$lFile['tmp_name'])
            throw new Exception('File does not exist: '.$lFile['name']);

        $lTempFolder = $this->tempFolder();
        $lNewName    = self::generateName($lFile['name']);

        if (!move_uploaded_file($lFile['tmp_name'], $lTempFolder . $lNewName) )
            throw new Exception('Error uploading: '.$lFile['name']);

        die(json_encode(['file_path' => $lTempFolder.$lNewName], JSON_UNESCAPED_UNICODE));
    }

    protected function tempFolder()
    {
        $lTempFolder = $this->storage.'temp/temp_'.date('Y_m_d').'/';

        if (!file_exists($lTempFolder))
            mkdir($lTempFolder, 0777);
        return $lTempFolder;
    }

    protected static function generateName($aName)
    {
        return time().'_'.mt_rand(1,99).mt_rand(1,99).
            strtolower(strrchr($aName, '.'));
    }
}
