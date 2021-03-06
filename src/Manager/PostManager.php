<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 05/10/2017
 * Time: 13:27
 */

namespace App\Manager;

use App\Entity\Post;
use Doctrine\ORM\EntityManager;

class PostManager
{
    private $em;
    private $repo;

    public function __construct(
        EntityManager $entityManager)
    {
        // DB
        $this->em = $entityManager;
        $this->repo = $this->em->getRepository(Post::class);
    }

    // CREATE
    public function persist(Post $post)
    {
        $this->em->persist($post);
        $this->em->flush();
    }

    public function new()
    {
        return new Post();
    }

    // READ
    public function getAll()
    {
        return $this->repo->findBy(
            array(),
            array('dateCreation' => 'DESC')
        );
    }

    public function getAllByTrick($id)
    {
        return $this->repo->getAllByTrick($id);
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
        $post = $this->repo->find($id);
        $this->em->remove($post);
        $this->em->flush();
    }

}
