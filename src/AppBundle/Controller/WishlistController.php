<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Wishlist;
use AppBundle\Services\Util;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WishlistController extends Controller
{
    public function addAction(Request $request)
    {
        $user = $this->getUser();

        if(!$user)
        {
            throw $this->createAccessDeniedException('not user');
        }

        $em = $this->getDoctrine()->getManager();
        $id = $request->request->get('id');
        $product = $em->getRepository('AppBundle:Products')->find($id);

        if(!$product)
        {
            throw $this->createNotFoundException('product');
        }

        $wishlist = new Wishlist();

        $wishlist->setUser($user);
        $wishlist->setProduct($product);

        $em->persist($wishlist);
        $em->flush();

        $result = array('returnCode' => 101);

        $res = json_encode($result);

        return new Response($res);
    }

    public function removeAction(Request $request)
    {
        $user = $this->getUser();

        if(!$user)
        {
            throw $this->createAccessDeniedException('not user');
        }

        $em = $this->getDoctrine()->getManager();
        $id = $request->request->get('id');
        $product = $em->getRepository('AppBundle:Products')->find($id);

        if(!$product)
        {
            throw $this->createNotFoundException('product');
        }

        $wish = $em->getRepository('AppBundle:Wishlist')->findOneBy(array('user' => $user,'product' => $product));

        $em->remove($wish);
        $em->flush();

        $result = array('returnCode' => 101);

        $res = json_encode($result);

        return new Response($res);
    }

    public function countAction()
    {
        $user = $this->getUser();

        if(!$user){
            return new Response("<span id='wishCount'></span>");
        }

        $wishes = $user->getWishes();

        $wishesCount = count($wishes);
        if($wishesCount == 0){
            $responce = "<span id='wishCount'></span>";;
        }else{
            $responce = "<span id='wishCount'>(".$wishesCount.")</span>";
        }
        return new Response($responce);
    }

    public function listAction()
    {
        $user = $this->getUser();

        if(!$user){
            throw $this->createNotFoundException('user');
        }


        $wishes = $user->getWishes();

        $wishesArray = array();

        foreach($wishes as $wish){
            $wishesArray[] = $wish->getProduct();
        }

       // Util::printArray($wishesArray);

        return $this->render('AppBundle:Wishes:list.html.twig',array(
            'wishes' => $wishesArray
        ));
    }
}
