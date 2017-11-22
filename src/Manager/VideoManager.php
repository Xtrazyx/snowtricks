<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 05/10/2017
 * Time: 13:27
 */

namespace App\Manager;

use App\Entity\Video;
use Doctrine\ORM\EntityManager;

class VideoManager
{
    private $em;
    private $repo;

    public function __construct(
        EntityManager $entityManager)
    {
        // DB
        $this->em = $entityManager;
        $this->repo = $entityManager->getRepository(Video::class);
    }

    // CREATE
    public function new()
    {
        return new Video();
    }

    public function persist(Video $video)
    {
        $this->em->persist($video);
        $this->em->flush();
    }

    public function persistOnly(Video $video)
    {
        $this->em->persist($video);
    }

    // READ
    public function getById($id)
    {
        return $this->repo->find($id);
    }


    // UPDATE
    public function update()
    {
        $this->em->flush();
    }

    // DELETE
    public function remove(Video $video)
    {
        $this->em->remove($video);
        $this->em->flush();
    }
}
