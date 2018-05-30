<?php
/**
 * Created by PhpStorm.
 * User: Minas
 * Date: 12/21/2017
 * Time: 1:28 AM
 */

namespace AppBundle\Services;


class Util
{
    public static function printArray($array)
    {
        echo "<pre>";
        print_r($array);
        die;
    }
}