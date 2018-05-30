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

        $em = $this->getDoctrine()->getManager();

        $locale = $request->getLocale();
        $products = $em->getRepository('AppBundle:Products')->findForSearch($q,$locale);

        return $this->render('AppBundle:Search:searched.html.twig',array(
            'products' => $products
        ));
    }
}
