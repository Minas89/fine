<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Banners;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BannersAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('url')
            ->add('type')
            ->add('active')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('url')
            ->add('target')
            ->add('type')
            ->add('active',null,array(
                'editable' => true
            ))
            ->add('image','string',array(
                'template' => 'AppBundle:Admin:image.html.twig'
            ))
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                ),
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('image','sonata_type_model_list',array(),array(
                'link_parameters' => array(
                    'context' => 'banners'
                )
            ))
            ->add('active')
            ->add('url')
            ->add('target',ChoiceType::class,array(
                'choices' => array(
                    'New tab' => '_blank',
                    'Same Tab' => '_self'
                ),
                'choices_as_values' => true,
            ))
            ->add('type',ChoiceType::class,array(
                'choices' => array(
                    'One Big' => Banners::BIG_IMG_FOR_INDEX,
                    'Cat Img' => Banners::CAT_IMG_FOR_INDEX,
                ),
                'choices_as_values' => true,
            ))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('url')
            ->add('type')
        ;
    }
}
