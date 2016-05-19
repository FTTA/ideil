<?php namespace App;
use Exception;

class ImagesManipulator
{
    protected $file_formats = array('.gif', '.png', '.jpg', '.bmp', '.jpeg');
    protected $tr_inserted = [];
    protected $tr_deleted  = [];
    protected $model_name = null;

    function __construct($aModelName)
    {
        if (empty($aModelName))
            throw new Exception('Empty model name');

        if (!class_exists($aModelName))
            throw new Exception('Invalid model name. Class "'.$aModelName.'" does not exist');

        $this->model_name = $aModelName;
    }

    protected function checkHandler($aMethodName)
    {
        if (empty($aMethodName))
            throw new Exception('Empty method name');

        if (!class_exists($this->model_name))
            throw new Exception('Invalid model name. Class "'.$this->model_name.'" does not exist');

        if (!method_exists($this->model_name, $aMethodName))
            throw new Exception('Invalid method name: '.$aMethodName);

        return true;
    }

    protected function perfome($aMethodName, $aParams)
    {
        if (empty($aParams))
            return call_user_func([$this->model_name, $aMethodName]);

        return call_user_func([$this->model_name, $aMethodName], $aParams);
    }

    public function getByOwner($aOwnerID)
    {
        $this->checkHandler('getByOwner');
        return $this->perfome('getByOwner', $aOwnerID);
    }

    public function getById($aParams)
    {
        $this->checkHandler('getById');
        return $this->perfome('getById', $aParams);
    }

    public function add($aDestination, $aFiles)
    {
        if (empty($aFiles))
            throw new Exception('Empty data for adding image');

        if (empty($aDestination) || !file_exists($aDestination))
            throw new Exception('Invalid destination folder');

        reset($aFiles);

        $lIsArray = true;
        if (!is_array(current($aFiles))) {
            $lIsArray = false;
            $aFiles = [$aFiles];
        }

        foreach ($aFiles as $lKey => $lValue) {
            if (empty($lValue['image_path']) || !file_exists($lValue['image_path']))
                throw new Exception('Invalid file');

            $aFiles[$lKey]['attr_'] = strrchr($lValue['image_path'], '/');

            $aFiles[$lKey]['attr_'] = strtolower(strrchr($aFiles[$lKey]['attr_'], '.'));

            if (!in_array($aFiles[$lKey]['attr_'], $this->file_formats))
                throw new Exception('Invalid file attr: *'.$lFileFormat);
        }

        foreach ($aFiles as $lKey => $lValue) {

            foreach ($lValue as $lEl => $lVal) {
                if (strripos($lEl, '_id') !== false && is_numeric($lVal)) {
                    $aFiles[$lKey]['file_name'] = $lVal.'_'.time().'_'.mt_rand(1,99).$lValue['attr_'];
                    //$aFiles[$lKey][$lEl]        = $lVal;
                    break;
                }
            }

            if (empty($aFiles[$lKey]['file_name']))
                 $aFiles[$lKey]['file_name'] = '_'.time().'_'.mt_rand(1,99).$lValue['attr_'];

            if (!copy($lValue['image_path'], $aDestination.$aFiles[$lKey]['file_name']))
                throw new Exception('Error copying file from '.$lValue['image_path'].
                    ' to '.$aDestination.$aFiles[$lKey]['file_name']);

            $this->tr_inserted[] = [
                'source'  => $lValue['image_path'],
                'created' => $aDestination.$aFiles[$lKey]['file_name']
            ];

            unset($aFiles[$lKey]['image_path'], $aFiles[$lKey]['attr_']);
        }

        if ($lIsArray) {
            $this->checkHandler('addMulti');
            return $this->perfome('addMulti', $aFiles);
        }
        else {
            reset($aFiles);
            $this->checkHandler('add');
            return $this->perfome('add', current($aFiles));
        }
    }

    public function delete($aDestinationFolder, $aImageId)
    {
        if (empty($aDestinationFolder))
            throw new Exception('Invalid destination folder');

        if (empty($aImageId))
            throw new Exception('Invalid image ID');

        if (!is_array($aImageId))
            $aImageId = [$aImageId];

        if (!file_exists($aDestinationFolder))
            throw new Exception('Folder does not exist: ' . $aDestinationFolder);


        $this->checkHandler('getById');
        $lImages = $this->perfome('getById', $aImageId);

        foreach ($lImages as $lVal)
            $this->tr_deleted[] = $aDestinationFolder.$lVal->file_name;


        $this->perfome('delete', $aImageId);
    }

    public function rollback()
    {
        if (empty($this->tr_inserted))
            return;

        reset($this->tr_inserted);
        do {
            $lTemp = current($this->tr_inserted);
            if (file_exists($lTemp['created']))
                unlink($lTemp['created']);
        }
        while (next($this->tr_inserted));

        $this->tr_inserted = [];
        $this->tr_deleted  = [];
    }

    public function commit()
    {
        if (!empty($this->tr_inserted)) {
            reset($this->tr_inserted);
            do {
                $lTemp = current($this->tr_inserted);
                if (file_exists($lTemp['source']))
                    unlink($lTemp['source']);
            }
            while (next($this->tr_inserted));
        }

        if (!empty($this->tr_deleted)) {
            reset($this->tr_deleted);
            do {
                $lTemp = current($this->tr_deleted);
                if (file_exists($lTemp))
                    unlink($lTemp);
            }
            while (next($this->tr_deleted));
        }

        $this->tr_inserted = [];
        $this->tr_deleted  = [];
    }
}
