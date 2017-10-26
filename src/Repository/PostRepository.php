<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 04/10/2017
 * Time: 16:21
 */

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    public function getAllByTrick($id)
    {
        $query = $this->createQueryBuilder('p')
            ->leftJoin('p.trick', 't')
            ->where('t.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
        ;

        return $query->getResult();
    }
}