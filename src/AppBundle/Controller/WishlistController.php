<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Wishlist;
use AppBundle\Entity\WishlistItem;
use AppBundle\Services\Util;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WishlistController extends BaseController
{
    public function addAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $id = $request->request->get('id');
        $product = $em->getRepository('AppBundle:Products')->find($id);
        $user = $this->getUser();


        if(!$product)
        {
            throw $this->createNotFoundException('product');
        }

        /**
         * @var Wishlist $wishlist
         */
        $wishlist = $em->getRepository('AppBundle:Wishlist')->checkUserWishlistExist($user,$this->getSessId());


        if(!$wishlist){
            $wishlist = new Wishlist();
            $wishlist->setUser($user);
            $wishlist->setSessId($this->getSessId());
            $em->persist($wishlist);
        }
        $em->flush();

        $wishlistItem = new WishlistItem();
        $wishlistItem->setProduct($product);
        $wishlistItem->setWishlist($wishlist);
        $em->persist($wishlistItem);
        $em->flush();

        $result = array('returnCode' => 101);

        $res = json_encode($result);

        return new Response($res);
    }

    public function removeAction(Request $request)
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $id = $request->request->get('id');
        $product = $em->getRepository('AppBundle:Products')->find($id);

        if(!$product)
        {
            throw $this->createNotFoundException('product');
        }
        $wishItemRepo = $em->getRepository('AppBundle:WishlistItem');
        $wishItem = $wishItemRepo->getByUserOrSessId($user,$this->getSessId(),$product);

        if(count($wishItem)){
            $em->remove($wishItem[0]);
        }
        $em->flush();

        $result = array('returnCode' => 101);

        $res = json_encode($result);

        return new Response($res);
    }

    public function countAction()
    {
        if($this->getUserWishes()) $wishesCount = count($this->getUserWishes());
        else $wishesCount = 0;
        if($wishesCount == 0){
            $responce = "<span id='wishCount'></span>";
        }else{
            $responce = "<span id='wishCount'>(".$wishesCount.")</span>";
        }
        return new Response($responce);
    }

    public function listAction()
    {
        $wishes =  $this->getUserWishes();

        return $this->render('AppBundle:Wishes:list.html.twig',array(
            'wishes' => $wishes
        ));
    }
}
