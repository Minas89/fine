<?php

namespace AppBundle\Controller;

use AppBundle\Services\Util;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{
    public function searchAction(Request $request)
    {
        if(!$request->query->has('q')){
            return $this->redirectToRoute('app_homepage');
        }

        $q = $request->query->get('q');

        $invalid_characters = array("$", "%", "#", "<", ">", "|", "!");
        $q = str_replace($invalid_characters, "", $q);

        if(empty($q)){
            throw $this->createNotFoundException('searc');
        }

        $em = $this->getDoctrine()->getManager();

        $locale = $request->getLocale();
        $products = $em->getRepository('AppBundle:Products')->findForSearch($q,$locale);

        $wishes = array();
        if($this->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            $wishesObjects = $em->getRepository('AppBundle:Wishlist')->findByUser($this->getUser());
            foreach($wishesObjects as $one)
            {
                $wishes[] = $one->getProduct();
            }
        }
        $array = array(
            'products' => $products,
            'q' => $q
        );

        if(count($wishes)){
            $array['wishes'] = $wishes;
        }



        return $this->render('AppBundle:Search:searched.html.twig',$array);
    }
}
