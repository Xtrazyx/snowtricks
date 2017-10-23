<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 10/10/2017
 * Time: 12:27
 */

namespace App\EventListener;

use App\Entity\Trick;
use App\Entity\TrickImage;
use App\Upload\FileUploader;
use App\Upload\Image;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\File\File;
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

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if(!$entity instanceof Image)
        {
            return;
        }

        $this->uploader->delete($entity);
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
            $entity->setFilename($this->uploader->getTargetDir() . $fileName);
            $entity->setAlt($fileName);
            $entity->setUrl(FileUploader::ASSET_PATH . $fileName);
        }
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Trick) {
            return;
        }

        /**
         * @param TrickImage $trickImage
         */
        foreach ($entity->getTrickImages() as $trickImage)
        {
            if (file_exists($fileName = $trickImage->getFileName())) {
                $trickImage->setfileName(new File($fileName));
            }
        }
    }
}