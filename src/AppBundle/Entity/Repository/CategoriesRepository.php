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
            return false;
        }
    }

    public function getForFilter($category,$products)
    {

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
            ->select('c')
            ->from('AppBundle:Categories','c')
            ->innerJoin('c.products','p')
            ;
        $list = [];
        if($products){
            foreach ($products as $product){
                $list[] = $product->getId();
            }

            $qb->where($qb->expr()->in('p.id',$list));
        }

        try{
            return $qb->getQuery()->getResult();
        }catch (\Exception $ex){
            echo $ex->getMessage();die;
            return false;
        }
    }
}
