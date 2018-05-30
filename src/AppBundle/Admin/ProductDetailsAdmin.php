<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ProductDetailsAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('titleArm')
            ->add('titleRus')
            ->add('titleEng')
            ->add('valueArm')
            ->add('valueRus')
            ->add('valueEng')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('titleArm')
            ->add('titleRus')
            ->add('titleEng')
            ->add('valueArm')
            ->add('valueRus')
            ->add('valueEng')
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
            ->add('titleArm')
            ->add('valueArm')
            ->add('titleRus')
            ->add('valueRus')
            ->add('titleEng')
            ->add('valueEng')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('titleArm')
            ->add('titleRus')
            ->add('titleEng')
            ->add('valueArm')
            ->add('valueRus')
            ->add('valueEng')
        ;
    }
}
