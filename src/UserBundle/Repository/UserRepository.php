<?php

namespace UserBundle\Repository;


class UserRepository extends \Doctrine\ORM\EntityRepository
{
    function findByrole(){
        $qb = $this->_em->createQueryBuilder();
        $qb->select('u')
            ->from($this->_entityName, 'u')
            ->where('u.roles LIKE :roles')
            ->setParameter('roles', '%"ROLE_DOCTOR"%');

        return $qb->getQuery()->getResult();
    }
}
