<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 04/10/2017
 * Time: 16:21
 */

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class TrickRepository extends EntityRepository
{
    public function getAllPagination($page, $nbPerPage)
    {
        $query = $this->createQueryBuilder('t')
            ->leftJoin('t.group', 'g')
            ->addSelect('g')
            ->leftJoin('t.trickImages', 'i')
            ->addSelect('i')
            ->orderBy('i.id', 'DESC')
            ->getQuery()
        ;

        $query
            ->setFirstResult(($page-1) * $nbPerPage)
            ->setMaxResults($nbPerPage)
        ;

        return new Paginator($query, true);
    }

    public function getAllCount()
    {
        $query = $this->createQueryBuilder('t')
            ->select('COUNT(t)')
            ->getQuery()
        ;

        return $query->getSingleScalarResult();
    }
}
