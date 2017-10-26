<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 05/10/2017
 * Time: 13:27
 */

namespace App\Manager;

use App\Action\ListTrickAction;
use App\Entity\Trick;
use Doctrine\ORM\EntityManager;

class TrickManager
{
    private $em;
    private $repo;

    public function __construct(
        EntityManager $entityManager)
    {
        // DB
        $this->em = $entityManager;
        $this->repo = $this->em->getRepository(Trick::class);
    }

    // CREATE
    public function persist(Trick $trick)
    {
        $this->em->persist($trick);
        $this->em->flush();
    }

    public function new()
    {
        return new Trick();
    }

    // READ
    public function getAllCount()
    {
        return $this->repo->getAllCount();
    }

    public function getAllPage($page)
    {
        return $this->repo->getAllPagination($page, ListTrickAction::NB_PER_PAGE);
    }

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
    public function delete($id)
    {
        $trick = $this->repo->find($id);
        $this->em->remove($trick);
        $this->em->flush();
    }
}