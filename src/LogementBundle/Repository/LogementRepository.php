<?php

namespace LogementBundle\Repository;

/**
 * LogementRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LogementRepository extends \Doctrine\ORM\EntityRepository
{
    public function getFreeLogement(){
        $query = LogementRepository::createQueryBuilder('l')
            ->where('l.capacite > l.resident')
            ->getQuery();
        return $query->getResult();
    }
    public function getCountPlaceFree(){
        return $this->createQueryBuilder('d')
            ->select('SUM(d.capacite) as number')
            ->getQuery()
            ->getOneOrNullResult();
    }
    public function getCountUsedPlace(){
        return $this->createQueryBuilder('d')
            ->select('SUM(d.resident) as number')
            ->getQuery()
            ->getOneOrNullResult();
    }
}