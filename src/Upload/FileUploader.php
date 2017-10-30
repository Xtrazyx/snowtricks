<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 10/10/2017
 * Time: 11:06
 */

namespace App\Upload;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Upload file to the server
 * Class FileUploader
 * @package App\Upload
 */
class FileUploader
{
    const ASSET_PATH = 'uploads/';

    private $rootDir;

    public function __construct($kernelProjectDir)
    {
        $this->rootDir = $kernelProjectDir . '/public/' . self::ASSET_PATH;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->getTargetDir(), $fileName);

        return $fileName;
    }

    public function delete(Image $entity)
    {
        if(file_exists($entity->getFilename())){
            unlink($entity->getFilename());
        }
    }

    public function getTargetDir()
    {
        return $this->rootDir;
    }
}
