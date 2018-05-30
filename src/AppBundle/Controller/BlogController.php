<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $blogs = $em->getRepository('AppBundle:Blogs')->findBy(array(),array('position' => 'DESC'));

        return $this->render('AppBundle:Blogs:all.html.twig',array(
            'blogs' => $blogs
        ));
    }

    public function oneAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $blog = $em->getRepository('AppBundle:Blogs')->findOneBySlug($slug);

        if(!$blog)
        {
            throw $this->createNotFoundException('blog');
        }

        return $this->render('AppBundle:Blogs:one.html.twig',array(
            'blog'=> $blog
        ));
    }
}
