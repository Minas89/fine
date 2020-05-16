<?php
/**
 * Created by PhpStorm.
 * User: minastonakanyan
 * Date: 1/20/19
 * Time: 9:05 PM
 */

namespace AppBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginListener {

    protected $em;

    public function __construct(EntityManager $em){

        $this->em = $em;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();
        $session = new Session();
        if($session->has('sessId')){
            $sessId = $session->get('sessId');
            $wishCheck = $this->em->getRepository('AppBundle:Wishlist')->findOneByUser($user);
            if($wishCheck){
                $wishItems = $this->em->getRepository('AppBundle:WishlistItem')->getByUserOrSessId(null,$sessId);
                if($wishItems)
                {

                    foreach ($wishItems as $item)
                    {
                        $checkIfItemInWishlist = $this->em->getRepository('AppBundle:WishlistItem')->findOneBy(['wishlist' => $wishCheck]);
                        if(!$checkIfItemInWishlist){
                            $item->setWishlist($wishCheck);
                            $this->em->persist($item);
                        }

                    }
                    $this->em->flush();
                }
            }else{
                $wish = $this->em->getRepository('AppBundle:Wishlist')->findOneBy(['sessId'=> $sessId]);
                if($wish){
                    $wish->setUser($user);
                    $this->em->persist($wish);
                }
            }

            $this->em->flush();
        }
    }
}
