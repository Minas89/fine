<?php
/**
 * Created by PhpStorm.
 * User: minas
 * Date: 7/9/20
 * Time: 1:18 PM
 */

namespace AppBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class FilterController extends BaseController
{
    public function filtersAction($products,$category)
    {
        $session = new Session();
        $filters = [];
        if($session->has('filters')){
            $filters = $session->get('filters');
        }

        $em = $this->getDoctrine()->getManager();
        $productsRepo = $em->getRepository('AppBundle:Products');
        $catsRepo = $em->getRepository('AppBundle:Categories');
        $creatorsRepo = $em->getRepository('AppBundle:Creators');
        $colors = $em->getRepository("AppBundle:Colors")->findAll();

        $categories = $catsRepo->getForFilter($category,$products);
        $creators = $creatorsRepo->getForFilter($products);
        $styles = $em->getRepository('AppBundle:Style')->findAll();
        $shippings = $em->getRepository('AppBundle:Shipping')->findAll();
        //dump($categories);

        $viewArray = [];
        $viewArray['products'] = $products;
        $viewArray['categories'] = $categories;
        $viewArray['category'] = $category;
        $viewArray['colors'] = $colors;
        $viewArray['currency'] = $this->getCurrency();
        $viewArray['creators'] = $creators;
        $viewArray['styles'] = $styles;
        $viewArray['shippings'] = $shippings;
        $viewArray['filters'] = $filters;

        return $this->render('AppBundle:Filters:filters.html.twig',$viewArray);
    }


    public function addFilterAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $locale = $request->request->get('locale');
        $session = new Session();
        $filtersArray = [];
        if($session->has('filters')){
            $filtersArray = $session->get('filters');
        }
        $filterName = $request->request->get('filterName',null);
        $filterValue = $request->request->get('filterValue',null);
        $resArr = [];
        $error = false;
        if(!is_null($filterName)){
            switch ($filterName){
                case "categories":
                    $categories = [];
                    if(isset($filtersArray['categories'])){
                        $categories = $filtersArray['categories'];
                    }
                    $category = $em->getRepository('AppBundle:Categories')->find((int)$filterValue);
                    $title = $category->getTitleEng();
                    /* if($locale == "en"){

                     }elseif ($locale == "am"){
                         $title = $color->getTitleArm();
                     }*/
                    $categories[$filterValue] = $title;
                    $add = $this->addFilterArraySession('categories',$categories);
                    if(!$add){
                        $error = true;
                    }
                    break;
                case "amount":
                    if($filterValue != " "){
                        $amount = explode(" ",$filterValue);
                        $minPrice = (int)$amount[0];
                        $maxPrice = (int)$amount[1];
                    }else{
                        $minPrice = $em->getRepository('AppBundle:Products')->getLowestPrice();
                        $maxPrice = $em->getRepository('AppBundle:Products')->getHighestPrice();
                    }

                    $add1 = $this->addFilterArraySession('minPrice',$minPrice);
                    $add2 = $this->addFilterArraySession('maxPrice',$maxPrice);
                    if(!($add1 and $add2)){
                        $error = true;
                    }
                    break;
                case "height":
                    if($filterValue != " "){
                        $height = explode(" ",$filterValue);
                        $minHeight = (int)$height[0];
                        $maxHeight = (int)$height[1];
                    }else{
                        $minHeight = $em->getRepository('AppBundle:Products')->getLowestHeight();
                        $maxHeight = $em->getRepository('AppBundle:Products')->getHighestHeight();
                    }

                    $add1 = $this->addFilterArraySession('minHeight',$minHeight);
                    $add2 = $this->addFilterArraySession('maxHeight',$maxHeight);
                    if(!($add1 and $add2)){
                        $error = true;
                    }
                    break;

                case "width":
                    if($filterValue != " "){
                        $width = explode(" ",$filterValue);
                        $minWidth = (int)$width[0];
                        $maxWidth = (int)$width[1];
                    }else{
                        $minWidth = $em->getRepository('AppBundle:Products')->getLowestWidth();
                        $maxWidth = $em->getRepository('AppBundle:Products')->getHighestWidth();
                    }

                    $add1 = $this->addFilterArraySession('minWidth',$minWidth);
                    $add2 = $this->addFilterArraySession('maxWidth',$maxWidth);
                    if(!($add1 and $add2)){
                        $error = true;
                    }
                    break;


                case "colors":
                    $colors = [];
                    if(isset($filtersArray['colors'])){
                        $colors = $filtersArray['colors'];
                    }
                    $color = $em->getRepository('AppBundle:Colors')->find((int)$filterValue);
                    $title = $color->getTitleEng();
                   /* if($locale == "en"){

                    }elseif ($locale == "am"){
                        $title = $color->getTitleArm();
                    }*/
                    $colors[$filterValue] = $title;
                    $add = $this->addFilterArraySession('colors',$colors);
                    if(!$add){
                        $error = true;
                    }
                    break;

                case "creators":
                    $creators = [];
                    if(isset($filtersArray['creators'])){
                        $creators = $filtersArray['creators'];
                    }
                    $creator = $em->getRepository('AppBundle:Creators')->find((int)$filterValue);
                    $title = $creator->getTitleEng();
                    /* if($locale == "en"){

                     }elseif ($locale == "am"){
                         $title = $color->getTitleArm();
                     }*/
                    $creators[$filterValue] = $title;
                    $add = $this->addFilterArraySession('creators',$creators);
                    if(!$add){
                        $error = true;
                    }
                    break;
                case "styles":
                    $styles = [];
                    if(isset($filtersArray['styles'])){
                        $styles = $filtersArray['styles'];
                    }
                    $style = $em->getRepository('AppBundle:Style')->find((int)$filterValue);
                    $title = $style->getTitleEng();
                    /* if($locale == "en"){

                     }elseif ($locale == "am"){
                         $title = $color->getTitleArm();
                     }*/
                    $styles[$filterValue] = $title;
                    $add = $this->addFilterArraySession('styles',$styles);
                    if(!$add){
                        $error = true;
                    }
                    break;

                case "shippings":
                    $shippings = [];
                    if(isset($filtersArray['shippings'])){
                        $shippings = $filtersArray['shippings'];
                    }
                    $shipping = $em->getRepository('AppBundle:Shipping')->find((int)$filterValue);
                    $title = $shipping->getTitleEng();
                    /* if($locale == "en"){

                     }elseif ($locale == "am"){
                         $title = $color->getTitleArm();
                     }*/
                    $shippings[$filterValue] = $title;
                    $add = $this->addFilterArraySession('shippings',$shippings);
                    if(!$add){
                        $error = true;
                    }
                    break;

                default:
                    $add = $this->addFilterArraySession($filterName,$filterValue);
                    if(!$add){
                        $error = true;
                    }
                    break;

            }
        }

        if($error){
            $resArr['code'] = 102;
        }else{
            $resArr['code'] = 101;
        }

        return $this->respond($resArr);
    }


    public function removeFilterAction(Request $request)
    {
        $filterName = $request->request->get('filterName',null);
        $resArr = [];
        $error = false;
        if(!is_null($filterName)){

            switch ($filterName){
                case "amount":
                    $remove1 = $this->removeFilterArraySession('minPrice');
                    $remove2 = $this->removeFilterArraySession('maxPrice');
                    if(!($remove1 and $remove2)){
                        $error = true;
                    }
                    break;
                case "height":
                    $remove1 = $this->removeFilterArraySession('minHeight');
                    $remove2 = $this->removeFilterArraySession('maxHeight');
                    if(!($remove1 and $remove2)){
                        $error = true;
                    }
                    break;

                case "width":
                    $remove1 = $this->removeFilterArraySession('minWidth');
                    $remove2 = $this->removeFilterArraySession('maxWidth');
                    if(!($remove1 and $remove2)){
                        $error = true;
                    }
                    break;

                case "colors":
                    $key = $request->request->get('key',null);
                    $remove = $this->removeFilterArraySession('colors',$key);
                    if(!$remove){
                        $error = true;
                    }
                    break;

                case "creators":
                    $key = $request->request->get('key',null);
                    $remove = $this->removeFilterArraySession('creators',$key);
                    if(!$remove){
                        $error = true;
                    }
                    break;

                case "styles":
                    $key = $request->request->get('key',null);
                    $remove = $this->removeFilterArraySession('styles',$key);
                    if(!$remove){
                        $error = true;
                    }
                    break;

                default:
                    $remove = $this->removeFilterArraySession($filterName);
                    if(!$remove){
                        $error = true;
                    }
                    break;
            }
        }

        if($error){
            $resArr['code'] = 102;
        }else{
            $resArr['code'] = 101;
        }

        return $this->respond($resArr);
    }

    private function addFilterArraySession($name,$value)
    {
        $filtersArray = [];
        $session = new Session();
        if($session->has('filters')){
            $filtersArray = $session->get('filters');
            $filtersArray[$name] = $value;
            $session->set('filters',$filtersArray);
        }else{
            $filtersArray[$name] = $value;
            $session->set('filters',$filtersArray);
        }
        return true;
    }

    private function removeFilterArraySession($filterName, $key = null){
        $session = new Session();
        if($session->has('filters')){
            $filtersArray = $session->get('filters');
            if(!is_null($key)){
                unset($filtersArray[$filterName][$key]);
                if(!count($filtersArray[$filterName])){
                    unset($filtersArray[$filterName]);
                }
            }else{
                unset($filtersArray[$filterName]);
            }
            $session->set('filters',$filtersArray);

            return true;
        }

        return false;
    }
}
