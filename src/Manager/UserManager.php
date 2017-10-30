<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 05/10/2017
 * Time: 13:27
 */

namespace App\Manager;

use App\Entity\User;
use Doctrine\ORM\EntityManager;

class UserManager
{
    private $em;
    private $repo;

    public function __construct(
        EntityManager $entityManager)
    {
        // DB
        $this->em = $entityManager;
        $this->repo = $this->em->getRepository(User::class);
    }

    // CREATE
    public function persist(User $user)
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    public function new()
    {
        return new User();
    }

    // READ
    public function getById($id)
    {
        return $this->repo->find($id);
    }

    public function getByEmail($email)
    {
        return $this->repo->findBy(array('email' => $email));
    }

    // UPDATE
    public function update()
    {
        $this->em->flush();
    }

    // DELETE
    public function delete($id)
    {
        $user = $this->repo->find($id);
        $this->em->remove($user);
        $this->em->flush();
    }
}
