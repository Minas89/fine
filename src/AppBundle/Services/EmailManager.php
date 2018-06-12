<?php
/**
 * Created by PhpStorm.
 * User: minastonakanyan
 * Date: 6/13/18
 * Time: 12:21 AM
 */

namespace AppBundle\Services;


use Symfony\Component\DependencyInjection\Container;

class EmailManager
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

}