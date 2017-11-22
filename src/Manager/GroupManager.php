<?php
/**
 * Created by PhpStorm.
 * Group: Xtrazyx
 * Date: 05/10/2017
 * Time: 13:27
 */

namespace App\Manager;

use App\Entity\Group;
use Doctrine\ORM\EntityManager;

class GroupManager
{
    private $em;
    private $repo;

    public function __construct(
        EntityManager $entityManager)
    {
        // DB
        $this->em = $entityManager;
        $this->repo = $this->em->getRepository(Group::class);
    }

    // READ
    public function getAll()
    {
        return $this->repo->findAll();
    }

    public function getByName($name)
    {
        return $this->repo->findOneBy(array(
            'name' => $name
        ));
    }

    // CREATE
    public function new()
    {
        return new Group();
    }

    // UPDATE
    public function persist(Group $group)
    {
        $this->em->persist($group);
        $this->em->flush();
    }
}
