<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Address;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Orders;
use AppBundle\Entity\OrderItems;

class CartController extends BaseController
{

    public function indexAction()
    {
        $session = new Session();
        if(!$session->has('cart'))$session->set('cart',array());
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('AppBundle:Products')->findArray(array_keys($session->get('cart')));
        return $this->render('AppBundle:Cart:cart.html.twig',array(
            'products' => $products,
            'cart' => $session->get('cart'),
        ));
    }
    public function addAction(Request $request)
    {
        $id = $request->request->get('id');

        $em = $this->getDoctrine()->getManager();

        //$product = $em->getRepository('AppBundle:Products')->find($id);

        $session = new Session();

        if(!$session->has('cart')){
            $session->set('cart',array());
        }

        $cart = $session->get('cart');

        if(array_key_exists($id,$cart)){
            // if product in cart

        }else{
        //new product
            $cart[$id] = 1;
        }

        $session->set('cart',$cart);

        $result =  array('returnCode' => 101,'id' => $id, 'msg' => 'exav', 'cart'=> $cart);

        $res = json_encode($result);

        return new Response($res);
    }

    public function cartCountAction()
    {
        $session = new Session();

        $cart = false;

        if(!$session->has('cart')){
            $products = 0;

        }else{
            $products = count($session->get('cart'));
            $cart = $session->get('cart');
        }

        return $this->render('AppBundle:Cart:cartCount.html.twig',array(
            'products' => $products,
            'cart' => $cart
        ));
    }

    public function removeAction(Request $request)
    {
        $id = $request->request->get('id');

        $session = new Session();

        $cart = $session->get('cart');

        $result = array('returnCode' => 201);

        if(array_key_exists($id,$cart))
        {
            unset($cart[$id]);
            $session->set('cart',$cart);

            $result = array('returnCode' => 101);
        }

        $res = json_encode($result);

        return new Response($res);
    }

    public function purchaseAction(Request $request)
    {
        $session = new Session();
        $cart = $session->get('cart');
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('AppBundle:Products')->findArray(array_keys($cart));

        $user = $this->getUser();

        if($request->isMethod(Request::METHOD_POST))
        {
            $total = 0;
            $newOrder = new Orders();
            $status = $em->getRepository('AppBundle:OrderStatuses')->find(1);
            $newOrder->setStatus($status);
            $newOrder->setUser($user);

            if($request->request->has('address')){
                $addressId = $request->request->get('address');
                $address = $em->getRepository('AppBundle:Address')->find($addressId);
            }

            if($request->request->has('newAddress')){
                $newAddress = $request->request->get('newAddress');
                $addressObject = new Address();
                $addressObject->setUser($user);
                $addressObject->setAddress($newAddress);
                $em->persist($addressObject);
                $em->flush();

                $address = $em->getRepository('AppBundle:Address')->findOneByUser($user);
            }

            $newOrder->setUserAddress($address);

            $em->persist($newOrder);
            $em->flush();

            foreach($products as $product)
            {
                $price = $product->getPrice();
                $orderItem = new OrderItems();
                $orderItem->setOrder($newOrder);
                $orderItem->setProduct($product);
                $orderItem->setPrice($price);
                $total += $price;


                $em->persist($orderItem);
            }
            $newOrder->setTotal($total);
            $em->persist($newOrder);
            $em->flush();

            $message = new \Swift_Message('Order Eamil');

            $message
                ->setFrom('symfonyminas@gmail.com')
                ->setTo($this->container->getParameter('order_email'))
                ->setBody($this->renderView('AppBundle:Email:orderEmail.html.twig'),'text/html')
            ;

            $this->get('mailer')->send($message);

            $session->remove('cart');
            return $this->redirectToRoute('app_homepage');

        }

        return $this->render('AppBundle:Cart:purchase.html.twig',array(
            'products' => $products,
            'cart' => $cart,
            'user' => $user,
        ));
    }

}
