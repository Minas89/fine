<?php
/**
 * Created by PhpStorm.
 * User: minas
 * Date: 7/16/20
 * Time: 4:27 PM
 */

namespace AppBundle\Controller\REST;


use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends BaseController
{

    public function changeCurrencyAction(Request $request)
    {
        $currency = $request->request->get('currency');
        setcookie('fineCurrency',$currency,time() + ( 2 * 365 * 24 * 60 * 60),'/');

        return $this->redirectToReferer();
    }
}
