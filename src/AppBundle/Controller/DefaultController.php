<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppBundle:Default:index.html.twig');
    }

    public function mainMenuAction()
    {
        $em = $this->getDoctrine()->getManager();

        $mainCategories = $em->getRepository('AppBundle:Categories')->getMainByPosition();

        return $this->render('AppBundle:Default:menu.html.twig',array(
            'mainCategories' => $mainCategories
        ));
    }

    public function footerCategoryMenuAction()
    {
        $em = $this->getDoctrine()->getManager();

        $mainCategories = $em->getRepository('AppBundle:Categories')->getMainByPosition();

        return $this->render('AppBundle:Default:footerCategories.html.twig',array(
            'mainCategories' => $mainCategories
        ));


    }

}
