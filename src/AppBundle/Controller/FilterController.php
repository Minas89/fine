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
                    $maxPrice = (int)$amount[2];
                    $add1 = $this->addFilterArraySession('minPrice',$minPrice);
                    $add2 = $this->addFilterArraySession('maxPrice',$maxPrice);
                    if(!($add1 and $add2)){
                        $error = true;
                    }
                    break;
                case "brands":
                    $brands = [];
                    if(isset($filtersArray['brands'])){
                        $brands = $filtersArray['brands'];
                    }
                    $brand = $em->getRepository('AppBundle:Brands')->find((int)$filterValue);
                    if($locale == "en"){
                        $title = $brand->getTitleEng();
                    }elseif ($locale == "am"){
                        $title = $brand->getTitleArm();
                    }
                    $brands[$filterValue] = $title;
                    $add = $this->addFilterArraySession('brands',$brands);
                    if(!$add){
                        $error = true;
                    }
                    break;
                case "seasons":
                    $seasons = [];
                    if(isset($filtersArray['seasons'])){
                        $seasons = $filtersArray['seasons'];
                    }
                    $season = $em->getRepository('AppBundle:Season')->find((int)$filterValue);
                    if($locale == "en"){
                        $title = $season->getTitleEng();
                    }elseif ($locale == "am"){
                        $title = $season->getTitleArm();
                    }
                    $seasons[$filterValue] = $title;
                    $add = $this->addFilterArraySession('seasons',$seasons);
                    if(!$add){
                        $error = true;
                    }
                    break;

                case "occasions":
                    $occasions = [];
                    if(isset($filtersArray['occasions'])){
                        $occasions = $filtersArray['occasions'];
                    }
                    $occasion = $em->getRepository('AppBundle:Occasion')->find((int)$filterValue);
                    if($locale == "en"){
                        $title = $occasion->getTitleEng();
                    }elseif ($locale == "am"){
                        $title = $occasion->getTitleArm();
                    }
                    $occasions[$filterValue] = $title;
                    $add = $this->addFilterArraySession('occasions',$occasions);
                    if(!$add){
                        $error = true;
                    }
                    break;



                case "styles":
                    $styles = [];
                    if(isset($filtersArray['styles'])){
                        $styles = $filtersArray['styles'];
                    }
                    $style = $em->getRepository('AppBundle:Styles')->find((int)$filterValue);
                    if($locale == "en"){
                        $title = $style->getTitleEng();
                    }elseif ($locale == "am"){
                        $title = $style->getTitleArm();
                    }
                    $styles[$filterValue] = $title;
                    $add = $this->addFilterArraySession('styles',$styles);
                    if(!$add){
                        $error = true;
                    }
                    break;

                case "conditions":
                    $conditions = [];
                    if(isset($filtersArray['conditions'])){
                        $conditions = $filtersArray['conditions'];
                    }
                    $condition = $em->getRepository('AppBundle:Conditions')->find((int)$filterValue);
                    if($locale == "en"){
                        $title = $condition->getTitleEng();
                    }elseif ($locale == "am"){
                        $title = $condition->getTitleArm();
                    }
                    $conditions[$filterValue] = $title;
                    $add = $this->addFilterArraySession('conditions',$conditions);
                    if(!$add){
                        $error = true;
                    }
                    break;

                case "colors":
                    $colors = [];
                    if(isset($filtersArray['colors'])){
                        $colors = $filtersArray['colors'];
                    }
                    $color = $em->getRepository('AppBundle:Color')->find((int)$filterValue);
                    if($locale == "en"){
                        $title = $color->getTitleEng();
                    }elseif ($locale == "am"){
                        $title = $color->getTitleArm();
                    }
                    $colors[$filterValue] = $title;
                    $add = $this->addFilterArraySession('colors',$colors);
                    if(!$add){
                        $error = true;
                    }
                    break;

                case "sizes":
                    $sizes = [];
                    if(isset($filtersArray['sizes'])){
                        $sizes = $filtersArray['sizes'];
                    }
                    $size = $em->getRepository('AppBundle:GlobalSyzes')->find((int)$filterValue);
                    $title = $size->getSize();
                    $sizes[$filterValue] = $title;
                    $add = $this->addFilterArraySession('sizes',$sizes);
                    if(!$add){
                        $error = true;
                    }
                    break;

                case "standarts":
                    $standarts = [];
                    if(isset($filtersArray['standarts'])){
                        $standarts = $filtersArray['standarts'];
                    }
                    $size = $em->getRepository('AppBundle:SizingStandarts')->find((int)$filterValue);
                    $title = $size->getSize();
                    $standarts[$filterValue] = $title;
                    $add = $this->addFilterArraySession('standarts',$standarts);
                    if(!$add){
                        $error = true;
                    }
                    break;

                case "genders":
                    $genders = [];
                    if(isset($filtersArray['genders'])){
                        $genders = $filtersArray['genders'];
                    }
                    $gender = $em->getRepository('AppBundle:Gender')->find((int)$filterValue);
                    if($locale == "en"){
                        $title = $gender->getTitleEng();
                    }elseif ($locale == "am"){
                        $title = $gender->getTitleArm();
                    }
                    $genders[$filterValue] = $title;
                    $add = $this->addFilterArraySession('genders',$genders);
                    if(!$add){
                        $error = true;
                    }
                    break;

                case "categories":
                    $categories = [];
                    if(isset($filtersArray['categories'])){
                        $categories = $filtersArray['categories'];
                    }
                    $category = $em->getRepository('AppBundle:Categories')->find((int)$filterValue);
                    if($locale == "en"){
                        $title = $category->getTitleEng();
                    }elseif ($locale == "am"){
                        $title = $category->getTitleArm();
                    }
                    $categories[$filterValue] = $title;
                    $add = $this->addFilterArraySession('categories',$categories);
                    if(!$add){
                        $error = true;
                    }
                    break;

                case "parentCategory":
                    //$parentCategories = [];

                    $parentCategory = $em->getRepository('AppBundle:Categories')->find((int)$filterValue);
                    if($locale == "en"){
                        $title = $parentCategory->getTitleEng();
                    }elseif ($locale == "am"){
                        $title = $parentCategory->getTitleArm();
                    }
                    $parentCategories[$filterValue] = $title;
                    $add = $this->addFilterArraySession('parentCategoryId',$filterValue);
                    $add2 = $this->addFilterArraySession('parentCategoryTitle',$title);
                    if(!$add and $add2){
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
                case "brands":
                    $key = $request->request->get('key',null);
                    $remove = $this->removeFilterArraySession('brands',$key);
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
