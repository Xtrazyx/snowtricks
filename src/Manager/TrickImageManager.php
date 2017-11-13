<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 05/10/2017
 * Time: 13:27
 */

namespace App\Manager;

use App\Entity\TrickImage;
use Doctrine\ORM\EntityManager;

class TrickImageManager
{
    private $em;
    private $repo;

    public function __construct(
        EntityManager $entityManager)
    {
        // DB
        $this->em = $entityManager;
        $this->repo = $this->em->getRepository(TrickImage::class);
    }

    // CREATE
    public function new(){
        return new TrickImage();
    }

    public function persist(TrickImage $image){
        $this->em->persist($image);
        $this->em->flush();
    }

    // READ
    public function getById($id){
        return $this->repo->find($id);
    }

    // REMOVE
    public function remove(TrickImage $trickImage)
    {
        $this->em->remove($trickImage);
        $this->em->flush();
    }

}
