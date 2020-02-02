<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Titles;

class CategoriesController extends BaseController
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
        $title = $em->getRepository('AppBundle:Titles')->findOneBy(['link' => Titles::SH_B_CAT],['id' => 'DESC']);


        return $this->render('AppBundle:Categories:shopBy.html.twig',array(
            'categories' => $categories,
            'title' => $title
        ));
    }
}
