<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Banners;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Titles;

class BannersController extends BaseController
{
    public function bigBannerAction()
    {
        $em = $this->getDoctrine()->getManager();

        $title = $em->getRepository('AppBundle:Titles')->findOneBy(['link' => Titles::BIG_BANNER],['id' => 'DESC']);

        $bigBanner = $em->getRepository('AppBundle:Banners')->findOneBy(
            array('type' => Banners::BIG_IMG_FOR_INDEX,'active' => 1),
            array('id' => 'desc')
        );


        return $this->render('AppBundle:Banners:indexBanners.html.twig',array(
            'bigBanner' => $bigBanner,
            'title' => $title
        ));
    }

    public function smallBannersAction()
    {
        $em = $this->getDoctrine()->getManager();

        $banners = $em->getRepository('AppBundle:Banners')->findBy(
            array('type' => Banners::CAT_IMG_FOR_INDEX),
            array('id' => 'DESC'),
            Banners::COUNT_ON_INDEX
        );

        return $this->render('AppBundle:Banners:indexSmallBanners.html.twig',array(
            'banners' => $banners
        ));
    }
}
