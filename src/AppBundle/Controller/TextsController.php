<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TextsController extends BaseController
{
    public function textAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $text = $em->getRepository('AppBundle:Texts')->findOneBySlug($slug);

        if(!$text){
            throw $this->createNotFoundException('text slug');
        }

        return $this->render('AppBundle:Texts:one.html.twig',array(
            'text' => $text
        ));
    }
}
