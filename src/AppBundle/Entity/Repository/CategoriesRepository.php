<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;

/**
 * CategoriesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoriesRepository extends EntityRepository
{
    public function getMainByPosition()
    {
        $qb = $this->getEntityManager()->createQuery(
            "SELECT c FROM AppBundle:Categories c WHERE c.parent is null ORDER BY c.position"
        );

        try{
            return $qb->getResult();
        }catch (EntityNotFoundException $e){
            error_log($e->getMessage());
        }
    }
}
