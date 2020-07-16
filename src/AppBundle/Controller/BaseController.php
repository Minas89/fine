<?php

namespace AppBundle\Controller;

use AppBundle\Entity\WishlistItem;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        if(!isset($_COOKIE['fineCurrency'])){
            $currency = 'USD';
            setcookie('fineCurrency',$currency,time() + ( 2 * 365 * 24 * 60 * 60));
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

    protected function getCurrency(){
        $request = Request::createFromGlobals();
        $csessId = false;
        $cookies = $request->cookies;
        if($cookies->has('fineCurrency')){
            $csessId = $cookies->get('fineCurrency');
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

    protected function redirectToReferer()
    {
        $request = Request::createFromGlobals();
        $referer = $request->headers->get('referer');

        return $this->redirect($referer);
    }

    /**
     * @var int
     */
    private $statusCode = 200;

    /**
     * @return int
     */
    protected function getStatusCode()
    {
        return $this->statusCode;
    }

    protected function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param $data
     * @param array $headers
     * @return JsonResponse
     */
    protected function respond($data,$headers = [])
    {
        return new JsonResponse($data,$this->getStatusCode(),$headers);
    }

    /**
     * Sets an error message and returns a JSON response
     *
     * @param string $errors
     *
     * @return JsonResponse
     */
    private function respondWithErrors($errors, $headers = [])
    {
        $data = [
            'errors' => $errors,
        ];

        return new JsonResponse($data, $this->getStatusCode(), $headers);
    }

    /**
     * Returns a 401 Unauthorized http response
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function respondUnauthorized($message = 'Not authorized!')
    {
        return $this->setStatusCode(401)->respondWithErrors($message);
    }

    /**
     * Returns a 422 Unprocessable Entity
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function respondValidationError($message = 'Validation errors')
    {
        return $this->setStatusCode(422)->respondWithErrors($message);
    }

    /**
     * Returns a 404 Not Found
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function respondNotFound($message = 'Not found!')
    {
        return $this->setStatusCode(404)->respondWithErrors($message);
    }

    /**
     * Returns a 201 Created
     *
     * @param array $data
     *
     * @return JsonResponse
     */
    public function respondCreated($data = [])
    {
        return $this->setStatusCode(201)->respond($data);
    }



}
