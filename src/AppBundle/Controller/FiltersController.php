<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Products;
use AppBundle\Services\Util;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FiltersController extends BaseController
{
    public function indexAction($category, $slug, $products)
    {
        $creatorView = false;
        $em = $this->getDoctrine()->getManager();

        $creatorObject = $em->getRepository('AppBundle:Creators')->findOneBySlug($slug);
        if($creatorObject){
            $current = $creatorObject;
            $creatorView = true;
        }else{
            /**
             * @var \AppBundle\Entity\Categories $parent
             */
            $parent = $em->getRepository('AppBundle:Categories')->findOneBySlug($slug);
            if(!$parent) {
                $parent = $em->getRepository('AppBundle:Categories')->findOneBySlug($category);
            }
            $current = $parent;

            $categories = array();

            for($i = 0; $i < 5; $i++){
                $parent = $parent->getParent();
                if(!$parent) break;
                $categories[] = $parent;
            }
        }




        $highest = $lowest = $minWidth = $maxWidth = $minHeight = $maxHeight = 0;

        $prices = array();
        $widths = array();
        $heights = array();

        foreach($products as $product)
        {
            $price = $product->getPrice();
            if(!is_null($price)){
                $prices[] = $price;
            }
            $width = $product->getWidth();
            if(!is_null($width)){
                $widths[] = $width;
            }

            $height = $product->getHeight();
            if(!is_null($height)){
                $heights[] = $height;
            }
        }
        if(count($prices) > 0){
            $highest = max($prices);
            $lowest = min($prices);
        }

        if(count($widths) > 0){
            $minWidth = min($widths);
            $maxWidth = max($widths);
        }

        if(count($heights) > 0){
            $minHeight = min($heights);
            $maxHeight = max($heights);
        }


        $colors = $em->getRepository('AppBundle:Colors')->findAll();

        //Util::printArray($widths);

        return $this->render('AppBundle:Filters:filters.html.twig',array(
            'current' => $current,
            'slug' => $slug,
            'products' => $products,
            'categories' => $categories,
            'highest' => $highest,
            'lowest' => $lowest,
            'colors' => $colors,
            'minWidth' => $minWidth,
            'maxWidth' => $maxWidth,
            'maxHeight' => $maxHeight,
            'minHeight' => $minHeight,
            'creatorView' => $creatorView
        ));
    }
}
