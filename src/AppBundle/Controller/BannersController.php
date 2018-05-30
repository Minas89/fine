<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Banners;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BannersController extends Controller
{
    public function bigBannerAction()
    {
        $em = $this->getDoctrine()->getManager();

        $bigBanner = $em->getRepository('AppBundle:Banners')->findOneBy(
            array('type' => Banners::BIG_IMG_FOR_INDEX,'active' => 1),
            array('id' => 'desc')
        );


        return $this->render('AppBundle:Banners:indexBanners.html.twig',array(
            'bigBanner' => $bigBanner,
        ));
    }
}
