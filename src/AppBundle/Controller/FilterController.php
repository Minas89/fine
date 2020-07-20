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
        //$session->clear();die;
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
                case "amount":
                    $amount = explode(" ",$filterValue);
                    $minPrice = (int)$amount[0];
                    $maxPrice = (int)$amount[1];
                    $add1 = $this->addFilterArraySession('minPrice',$minPrice);
                    $add2 = $this->addFilterArraySession('maxPrice',$maxPrice);
                    if(!($add1 and $add2)){
                        $error = true;
                    }
                    break;
                case "height":
                    $height = explode(" ",$filterValue);
                    $minHeight = (int)$height[0];
                    $maxHeight = (int)$height[1];
                    $add1 = $this->addFilterArraySession('minHeight',$minHeight);
                    $add2 = $this->addFilterArraySession('maxHeight',$maxHeight);
                    if(!($add1 and $add2)){
                        $error = true;
                    }
                    break;

                case "width":
                    $width = explode(" ",$filterValue);
                    $minWidth = (int)$width[0];
                    $maxWidth = (int)$width[1];
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
                case "colors":
                    $key = $request->request->get('key',null);
                    $remove = $this->removeFilterArraySession('colors',$key);
                    if(!$remove){
                        $error = true;
                    }
                    break;
                case "seasons":
                    $key = $request->request->get('key',null);
                    $remove = $this->removeFilterArraySession('seasons',$key);
                    if(!$remove){
                        $error = true;
                    }
                    break;

                case "occasions":
                    $key = $request->request->get('key',null);
                    $remove = $this->removeFilterArraySession('occasions',$key);
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
                case "conditions":
                    $key = $request->request->get('key',null);
                    $remove = $this->removeFilterArraySession('conditions',$key);
                    if(!$remove){
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
                case "sizes":
                    $key = $request->request->get('key',null);
                    $remove = $this->removeFilterArraySession('sizes',$key);
                    if(!$remove){
                        $error = true;
                    }
                    break;
                case "standarts":
                    $key = $request->request->get('key',null);
                    $remove = $this->removeFilterArraySession('standarts',$key);
                    if(!$remove){
                        $error = true;
                    }
                    break;
                case "genders":
                    $key = $request->request->get('key',null);
                    $remove = $this->removeFilterArraySession('genders',$key);
                    if(!$remove){
                        $error = true;
                    }
                    break;
                case "categories":
                    $key = $request->request->get('key',null);
                    $remove = $this->removeFilterArraySession('categories',$key);
                    if(!$remove){
                        $error = true;
                    }
                    break;

                case "parentCategory":
                    $remove = $this->removeFilterArraySession('parentCategoryId');
                    $remove2 = $this->removeFilterArraySession('parentCategoryTitle');
                    if(!$remove or !$remove2){
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
