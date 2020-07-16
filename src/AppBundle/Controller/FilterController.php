<?php
/**
 * Created by PhpStorm.
 * User: minas
 * Date: 7/9/20
 * Time: 1:18 PM
 */

namespace AppBundle\Controller;


use Symfony\Component\HttpFoundation\Session\Session;

class FilterController extends BaseController
{
    public function filtersAction($products,$category)
    {
        $session = new Session();
        $filters = [];
        if($session->has('filters')){
            $filters = $session->get('filters');
        }

        $em = $this->getDoctrine()->getManager();
        $productsRepo = $this->getDoctrine()->getRepository('AppBundle:Products');
        $catsRepo = $this->getDoctrine()->getRepository('AppBundle:Categories');
        $colors = $em->getRepository("AppBundle:Colors")->findAll();

        $categories = $catsRepo->getForFilter($category,$products);
        //dump($categories);

        $viewArray = [];
        $viewArray['products'] = $products;
        $viewArray['categories'] = $categories;
        $viewArray['colors'] = $colors;
        $viewArray['currency'] = $this->getCurrency();

        return $this->render('AppBundle:Filters:filters.html.twig',$viewArray);
    }
}
