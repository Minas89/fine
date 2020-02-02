<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CreatorsController extends BaseController
{
    public function allByCatAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('AppBundle:Categories')->findOneBySlug($slug);
        $creators = $em->getRepository('AppBundle:Creators')->findByCategory($category);
        $mainCats = $em->getRepository('AppBundle:Categories')->getMainByPosition();

        return $this->render('AppBundle:Creators:allByCat.html.twig',array(
            'category' => $category,
            'creators' => $creators,
            'mainCats' => $mainCats
        ));
    }

    public function productsAction($slug,$creator, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('AppBundle:Categories')->findOneBySlug($slug);
        $creator = $em->getRepository('AppBundle:Creators')->findOneBySlug($creator);

        if($request->query->has('sort')){
            $sort = $request->query->get('sort');
        }else{
            $sort = 'newest';
        }

        switch($sort) {
            case 'newest' :
                $criteria = 'created';
                $order = 'DESC';
                break;

            case 'price-high' :
                $criteria = 'price';
                $order = 'DESC';
                break;
            case 'price-low' :
                $criteria = 'price';
                $order = 'ASC';
                break;
        }

        $lowPrice = $request->query->get('minPrice');
        $highPrice = $request->query->get('maxPrice');
        $minWidth = $request->query->get('minWidth');
        $maxWidth = $request->query->get('maxWidth');
        $minHeight = $request->query->get('minHeight');
        $maxHeight = $request->query->get('maxHeight');


        $products = $em->getRepository('AppBundle:Products')->findFiltered(
            $category,
            $lowPrice,
            $highPrice,
            $minWidth,
            $maxWidth,
            $minHeight,
            $maxHeight,
            $creator

        );

        //$products = $em->getRepository('AppBundle:Products')->findBy(array('creator'=> $creator),array($criteria => $order));

        $wishes = array();
        if($this->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            $wishesObjects = $em->getRepository('AppBundle:Wishlist')->findByUser($this->getUser());
            foreach($wishesObjects as $one)
            {
                $wishes[] = $one->getProduct();
            }
        }

        /*$products = $em->getRepository('AppBundle:Products')->findByCreator($creator);*/

        return $this->render('AppBundle:Products:byCat.html.twig',array(
            'category' => $category,
            'lastCategory' => $creator,
            'products' => $products,
            'sort' => $sort,
            'wishes' => $wishes,
            'filterCategory' => $category,
            'filterSlug' => $slug
        ));
    }
}
