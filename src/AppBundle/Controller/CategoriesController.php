<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoriesController extends Controller
{
    public function catByCatAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $catRepository = $em->getRepository('AppBundle:Categories');

        $category = $catRepository->findOneBySlug($slug);
        if(!$category)
        {
            throw $this->createNotFoundException('category');
        }

        return $this->render('AppBundle:Categories:catByCat.html.twig',array(
            'category' => $category
        ));
    }

    public function shopByCategoryAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('AppBundle:Categories')->findBy(array('shopBy' => 1),array('id' => 'desc'),Categories::SHOP_BY_LIMIT);

        return $this->render('AppBundle:Categories:shopBy.html.twig',array(
            'categories' => $categories
        ));
    }
}
