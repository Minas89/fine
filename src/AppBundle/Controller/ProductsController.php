<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Categories;
use AppBundle\Entity\Products;
use AppBundle\Entity\Titles;
use AppBundle\Services\Util;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class ProductsController extends BaseController
{
    public function byCatAction($category,$slug,Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $lastcategory = $em->getRepository('AppBundle:Categories')->findOneBySlug($slug);
        $maincategory = $em->getRepository('AppBundle:Categories')->findOneBySlug($category);

        $colors = $em->getRepository('AppBundle:Colors')->findAll();

        if(!$lastcategory or !$maincategory)
        {
            throw $this->createNotFoundException('category or last');
        }

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
        $colorArray = array();
        if($request->query->has('color'))
        {
            $color = $request->query->get('color');
            $colorArray = explode(',',$color);
        }else{
            $color = null;
        }

        $products = $em->getRepository('AppBundle:Products')->findFiltered(
            $lastcategory,
            $lowPrice,
            $highPrice,
            $minWidth,
            $maxWidth,
            $minHeight,
            $maxHeight,
            $colorArray
        );



        $wishes = $this->getUserWishes();



        return $this->render('AppBundle:Products:byCat.html.twig',array(
            'category' => $maincategory,
            'lastCategory' => $lastcategory,
            'products' => $products,
            'sort' => $sort,
            'colors' => $colors,
            'wishes' => $wishes,
            'filterCategory' => $category,
            'filterSlug' => $slug
        ));

    }

    public function singleAction($category,$slug)
    {
        $em = $this->getDoctrine()->getManager();
        $maincategory = $em->getRepository('AppBundle:Categories')->findOneBySlug($category);
        $product = $em->getRepository('AppBundle:Products')->findOneBySlug($slug);

        $session = new Session();

        if($session->has('cart')){
            $cart = $session->get('cart');
        }else{
            $cart = false;
        }

        $wishes = $this->getUserWishes();


        return $this->render('AppBundle:Products:single.html.twig',array(
            'category' => $maincategory,
            'product' => $product,
            'cart' => $cart,
            'wishes' => $wishes
        ));
    }

    public function topCarouselAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('AppBundle:Products')->findBy(array('top' => 1),array('id' => 'desc'),Products::TOP_CAROUSEL_LIMIT);
        $title = $em->getRepository('AppBundle:Titles')->findOneBy(['link' => Titles::TOP],['id' => 'DESC']);

        return $this->render('AppBundle:Products:topCarousel.html.twig',array(
            'products' => $products,
            'title' => $title
        ));
    }

    public function newArrivalsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('AppBundle:Products')->findBy(array('new' => 1),array('id' => 'desc'),Products::newArrivals);
        $title = $em->getRepository('AppBundle:Titles')->findOneBy(['link' => Titles::NEW_ARRIVALS],['id' => 'DESC']);


        return $this->render('AppBundle:Products:newArrivals.html.twig',array(
            'products' => $products,
            'title' => $title,
        ));
    }

    public function newsByCatAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var Categories $category
         */
        $category = $em->getRepository('AppBundle:Categories')->findOneBySlug($slug);
        $childCats = $category->getChildren();

        if(count($childCats)){
            $products = $em->getRepository('AppBundle:Products')->findNewProductsByMainCategory($category);
        }else{
            $products = $em->getRepository('AppBundle:Products')->findBy(array('category' => $category,'new' => 1),array('id' => 'desc'));
        }



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

        return $this->render('AppBundle:Products:newsByCat.html.twig',array(
            'category' => $category,
            'products' => $products,
            'sort' => $sort,
        ));
    }

    public function alsoLikeAction(Products $product)
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('AppBundle:Products')->getAlsoLike($product);


        if($products){
            // Util::dumpArray($similarProducts);
            if(count($products) < 4){
                $limit = 4 - count($products);
                $additionals = $em->getRepository('AppBundle:Products')
                    ->getAdditionalExamples($product,$limit);
            }
        }

        return $this->render('AppBundle:Products:alsoLike.html.twig',[
            'products' => $products
        ]);
    }

}
