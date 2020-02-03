<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Address;
use AppBundle\Entity\User;
use AppBundle\Form\RegisterType2;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

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

    public function sendPriceRequestAction(Request $request)
    {
        if(!$request->isMethod($request::METHOD_POST)){
            return $this->redirectToRoute('app_homepage');
        }

        $number = $request->request->get('phone');
        $message = $request->request->get('message');
        $productId = $request->request->get('productId');
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository('AppBundle:Products')->find($productId);

        $params = [
            'number' => $number,
            'message' => $message,
            'product' => $product,
            'user' => $this->getUser()
        ];

        $to = $this->container->getParameter('order_email');
        $subject = 'Price Request';
        $template = "AppBundle:Email:price_request.html.twig";

        $this->sendEmail($to,$subject,$template,$params);

        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }


    private function sendEmail($to, $subject,$template,array $params)
    {
        $message = (new \Swift_Message($subject))
            ->setFrom('send@example.com')
            ->setTo($to)
            ->setBody(
                $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                    //'Emails/registration.html.twig',
                    $template,
                    $params
                ),
                'text/html'
            )
            /*
             * If you also want to include a plaintext version of the message
            ->addPart(
                $this->renderView(
                    'Emails/registration.txt.twig',
                    array('name' => $name)
                ),
                'text/plain'
            )
            */
        ;

        try{
            $this->container->get('mailer')->send($message);
        }catch (\Exception $exception){
            echo $exception->getMessage();
        }

        return true;
    }

    public function registerStep2Action(Request $request)
    {
        $form = $this->createForm(new RegisterType2());

        $form->handleRequest($request);

        if($request->isMethod(Request::METHOD_POST)){
            if($form->isValid()){
                $data = $form->getData();
                $formHandler = $this->container->get('fos_user.registration.form.handler');
                $session = new Session();
                $userSession = $session->get('user');

                $user = new User();
                $user->setUsername($userSession->getUsername());
                $user->setEmail($userSession->getEmail());
                $user->setPlainPassword($userSession->getSalt());
                $user->setTitle($data['title']);
                $user->setGender($data['gender']);
                $user->setFirstname($data['firstname']);
                $user->setLastname($data['lastname']);
                $user->setPhone($userSession->getPhone());
                $user->setDateOfBirth($data['dateOfBirth']);
                $user->setEnabled(true);

                $em = $this->getDoctrine()->getManager();

                $em->persist($user);
                $em->flush();

                $this->addFlash('fos_user_success', 'registration.flash.user_created');
                $route = 'app_homepage';
                $url = $this->container->get('router')->generate($route);
                $response = new RedirectResponse($url);
                $this->authenticateUser($user,$response);
                $session->remove('user');
                return $response;
            }
        }
        return $this->render('AppBundle:User:register2.html.twig',[
            'form' => $form->createView()
        ]);
    }

    protected function authenticateUser(UserInterface $user, Response $response)
    {
        try {
            $this->container->get('fos_user.security.login_manager')->loginUser(
                $this->container->getParameter('fos_user.firewall_name'),
                $user,
                $response);
        } catch (AccountStatusException $ex) {
            // We simply do not authenticate users which do not pass the user
            // checker (not enabled, expired, etc.).
        }
    }

}
