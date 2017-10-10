<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 10/10/2017
 * Time: 12:27
 */

namespace App\EventListener;

use App\Upload\FileUploader;
use App\Upload\Image;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploadListener
{
    private $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    private function uploadFile($entity)
    {
        // upload only works for Image class inherited entities
        if (!$entity instanceof Image) {
            return;
        }

        $file = $entity->getFilename();

        // only upload new files
        if ($file instanceof UploadedFile) {
            $fileName = $this->uploader->upload($file);
            $entity->setFilename($fileName);
        }
    }
}