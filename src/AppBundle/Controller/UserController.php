<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Address;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function setFioAction(Request $request)
    {
        $user = $this->getUser();

        if(!$user)
        {
            throw $this->createNotFoundException('not user');
        }

        if($request->isMethod(Request::METHOD_POST))
        {
            $em = $this->getDoctrine()->getManager();
            $translator = $this->container->get('translator');
            $firstname = $request->request->get('first');
            $lastname = $request->request->get('last');
            $email = $request->request->get('email');
            $title = $request->request->get('title');
            $emailEmpty = false;
            if(empty($email))
            {
                $emailEmpty = true;
            }
            $email = filter_var($email,FILTER_SANITIZE_EMAIL);

            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                if($emailEmpty)
                {
                    $result = array('returnCode' => 102,'msg' => $translator->trans('account_menu.mand_field'));
                }else{
                    $result = array('returnCode' => 102,'msg' => $translator->trans('account_menu.not_valid_email'));

                }
            }else {
                $emailCheck = $em->getRepository('AppBundle:User')->findOneByEmail($email);
                if ($emailCheck) {
                    if ($emailCheck->getId() != $user->getId()) {
                        $result = array('returnCode' => 102, 'msg' => $translator->trans('account_menu.hasEmail'));
                    }
                }

                if(!isset($result)){
                    if(!empty($firstname)){
                        $user->setFirstname($firstname);
                    }

                    if(!empty($lastname)){
                        $user->setLastname($lastname);
                    }

                    $user->setEmail($email);

                    $user->setTitle($title);

                    $em->persist($user);
                    $em->flush();

                    $result = array('returnCode' => 101,'msg' => $translator->trans('account_menu.savedSuccess'));
                }
            }

            $res = json_encode($result);

            return new Response($res);

        }

        return false;
    }


    public function deliveryInfoAction(Request $request)
    {
        $user = $this->getUser();
        if(!$user)
        {
            throw $this->createNotFoundException('User');
        }
        $em = $this->getDoctrine()->getManager();
        $translator = $this->container->get('translator');
        $addresses = $em->getRepository('AppBundle:Address')->findByUser($user);
        if($request->isMethod(Request::METHOD_POST))
        {
            $phone = $request->request->get('phone');

            $user->setPhone($phone);

            $em->persist($user);
            $em->flush();

            $result = array('returnCode' => 101,'msg' => $translator->trans('account_menu.savedSuccess'));

            $res = json_encode($result);

            return new Response($res);
        }

        return $this->render('FOSUserBundle:Profile:deliveryInfo.html.twig',array(
            'user' => $user,
            'addresses' => $addresses
        ));
    }

    public function addAddressAction(Request $request)
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createNotFoundException('User');
        }

        if ($request->isMethod(Request::METHOD_POST)) {
            $address = $request->request->get('userAddress');
            $em = $this->getDoctrine()->getManager();
            $newAddress = new Address();

            $newAddress->setAddress($address);
            $newAddress->setUser($user);

            $em->persist($newAddress);
            $em->flush();

            return $this->redirectToRoute('profile_delivery_info');
        }
    }

    public function removeAddressAction(Request $request)
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createNotFoundException('User');
        }

        if($request->isMethod(Request::METHOD_POST))
        {
            $id = $request->request->get('id');

            $em = $this->getDoctrine()->getManager();

            $address = $em->getRepository('AppBundle:Address')->find($id);

            $adUser = $address->getUser();

            if($user == $adUser)
            {
                $em->remove($address);
                $em->flush();
                return $this->redirectToRoute('profile_delivery_info');
            }
        }

        throw $this->createAccessDeniedException('mi ban en chi');
    }
}
