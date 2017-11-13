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
        $this->repo = $this->em->getRepository(Video::class);
    }

    // REMOVE
    public function remove(Video $video)
    {
        $this->em->remove($video);
        $this->em->flush();
    }
}
