<?php

namespace AppBundle\Controller;

use AppBundle\Entity\WishlistItem;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class BaseController extends Controller
{
    public function __construct()
    {
        $session = new Session();
        //$session->clear();die;
        if(!$session->get('sessId')){
            if(isset($_COOKIE['sessId'])){
                $sessionKey = $_COOKIE['sessId'];
            }else{
                $sessionKey = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyz', 5)), 0, 26);
            }
            $session->set('sessId',$sessionKey);
            setcookie('sessId',$sessionKey,time() + ( 2 * 365 * 24 * 60 * 60));
        }

    }

    protected function getSessId(){
        $request = Request::createFromGlobals();
        $csessId = false;
        $cookies = $request->cookies;
        if($cookies->has('sessId')){
            $csessId = $cookies->get('sessId');
        }

        return $csessId;
    }

    protected function getUserWishes()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $sessId = $this->getSessId();

        /**
         * @var WishlistItem[]
         */
        $wishes = $em->getRepository('AppBundle:WishlistItem')->getByUserOrSessId($user,$sessId);

        $wishesArray = array();

        if($wishes){
            foreach($wishes as $wish){
                $wishesArray[] = $wish->getProduct();
            }
        }

        return count($wishesArray) ? $wishesArray : false;
    }
}
