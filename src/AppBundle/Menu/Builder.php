<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function accountMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->setChildrenAttributes(array(
            'id' => 'accountMenu',
            'class' => 'pl0',
        ));

        $em = $this->container->get('doctrine')->getManager();

        $request = $this->container->get('request');

        $locale = $request->getLocale();

        $tranlator = $this->container->get('translator');

        $menu->addChild($tranlator->trans('account_menu.personalInfo'),array('route'=> 'fos_user_profile_show'));
        $menu->addChild($tranlator->trans('account_menu.loginInfo'),array('route'=> 'fos_user_change_password'));
        $menu->addChild($tranlator->trans('account_menu.deliveryInfo'),array('route'=> 'profile_delivery_info'));
       // $menu->addChild($tranlator->trans('account_menu.paymentInfo'),array('uri'=> '#'));


        return $menu;
    }
}