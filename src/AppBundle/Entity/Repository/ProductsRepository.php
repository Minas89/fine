<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Categories;
use AppBundle\Entity\Products;
use Doctrine\ORM\EntityRepository;
use AppBundle\Services\Util;
/**
 * ProductsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductsRepository extends EntityRepository
{
    public function findProductByColors($ids = array())
    {
        //$ids = array(1,2,3,4);

        $ids = implode(',',$ids);
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT DISTINCT(product_id) FROM products_colors WHERE color_id IN($ids)";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function findFiltered(Categories $category,$criteria,$order, array $filters)
    {
        $qb = $this->createQueryBuilder('p');
        $ids = [];
        if(count($category->getChildren())){
            foreach ($category->getChildren() as $child)
            {
                if(count($child->getChildren())){
                    foreach ($child->getChildren() as $child){
                        $ids[] = $child->getId();
                    }
                }else{
                    $ids[] = $child->getId();
                }

            }
        }else{
            $ids[] = $category->getId();
        }

        $qb
            ->select('p,c')
            ->innerJoin('p.category','c')
            ->where($qb->expr()->in('c.id',$ids))
            ->orderBy("p.".$criteria,$order)
            ;


        if(isset($filters['minPrice']) and isset($filters['maxPrice'])){
            $qb->andWhere($qb->expr()->between('p.price',$filters['minPrice'],$filters['maxPrice']));
        }

        if(isset($filters['onSale'])){
            $qb->andWhere('p.sale = 1');
        }

        if(isset($filters['minHeight']) and isset($filters['maxHeight'])){
            $qb->andWhere($qb->expr()->between('p.height',$filters['minHeight'],$filters['maxHeight']));
        }

        if(isset($filters['minWidth']) and isset($filters['maxWidth'])){
            $qb->andWhere($qb->expr()->between('p.width',$filters['minWidth'],$filters['maxWidth']));
        }

        if(isset($filters['colors'])){
            $colors = $filters['colors'];
            $colorIds = [];
            foreach ($colors as $key => $color){
                $colorIds[] = (int)$key;
            }

            //var_dump($colorIds);die;
            $qb->innerJoin('p.colors','colors');
            $qb->andWhere($qb->expr()->in('colors.id',$colorIds));
           // $params['colorIds'] = $colorIds;
        }

        if(isset($filters['creators'])){
            $creators = $filters['creators'];
            $creatorIds = [];
            foreach ($creators as $key => $creator){
                $creatorIds[] = (int)$key;
            }

            //var_dump($colorIds);die;
            $qb->andWhere($qb->expr()->in('p.creator',$creatorIds));
            // $params['colorIds'] = $colorIds;
        }

        try{
            return $qb->getQuery()->getResult();
        }catch (\Exception $ex){
            echo $ex->getMessage();die;
            return false;
        }

    }

    public function findArray($array)
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.id in (:array)')
            ->setParameter('array',$array);

        return $qb->getQuery()->getResult();
    }

    public function findForSearch($q,$locale)
    {
        switch($locale){
            case 'en':
                $title = 'titleEng';
                break;
            case 'ru':
                $title = 'titleRus';
                break;
            case 'am':
                $title = 'titleArm';
                break;
        }
        $query = $this->getEntityManager()->createQuery("
            SELECT p FROM AppBundle:Products p
            WHERE p.$title LIKE :q
        ")->setParameter('q','%'.$q.'%');

        return $query->getResult();
    }

    public function findNewProductsByMainCategory(Categories $category)
    {
        $em = $this->getEntityManager();

        $childs = $category->getChildren();

        $idsArray = array();
        foreach ($childs as $child){
            $idsArray[] = $child->getId();
        }

        $ids = implode(',',$idsArray);

        $qb = $em->createQuery(
            "SELECT p FROM AppBundle:Products p
                  WHERE p.category IN ($ids) and p.new = :new"
        )->setParameter('new',1);

        return $qb->getResult();
    }

    public function findProductsByMainCategory(Categories $category)
    {
        $em = $this->getEntityManager();

        $childs = $category->getChildren();

        $idsArray = array();
        foreach ($childs as $child){
            $idsArray[] = $child->getId();
        }

        $ids = implode(',',$idsArray);

        $qb = $em->createQuery(
            "SELECT p FROM AppBundle:Products p
                  WHERE p.category IN ($ids)"
        );

        return $qb->getResult();
    }

    public function getAlsoLike(Products $products)
    {
        $em = $this->getEntityManager();

        $category = $products->getCategory();

        $qb = $em->createQuery(
            "SELECT p FROM AppBundle:Products p
                  WHERE p.category = :category AND p.id != :id"
        )->setParameters([
            'category'=> $category,
            'id' => $products->getId()
        ])->setMaxResults(4);

        return $qb->getResult();
    }

    public function getAdditionalExamples(Products $products,$limit)
    {
        $em = $this->getEntityManager();

        $childs = $products->getCategory()->getParent()->getChildren();
        $ids = '';

        if(count($childs)){
            $idsArray = array();
            foreach ($childs as $child){
                $idsArray[] = $child->getId();
            }

            $ids = implode(',',$idsArray);

        }

        $qb = $em->createQuery(
            "SELECT p FROM AppBundle:Products p
                  WHERE p.category IN ($ids)"
        )->setMaxResults($limit);

        return $qb->getResult();
    }
}
