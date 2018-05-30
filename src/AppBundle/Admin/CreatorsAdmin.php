<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CreatorsAdmin extends AbstractAdmin
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
            ->add('textArm')
            ->add('textRus')
            ->add('textEng')
            ->add('slug')
            ->add('position')
            ->add('metaKeywords')
            ->add('metaDescription')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('category')
            ->add('titleArm')
            ->add('titleRus')
            ->add('titleEng')
            ->add('slug')
            ->add('position')
            ->add('metaKeywords')
            ->add('metaDescription')
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
            ->add('category')
            ->add('titleArm')
            ->add('titleRus')
            ->add('titleEng')
            ->add('textArm','ckeditor')
            ->add('textRus','ckeditor')
            ->add('textEng','ckeditor')
            ->add('slug')
            ->add('position')
            ->add('image','sonata_type_model_list',array(),array(
                'link_parameters' => array(
                    'context' => 'creators'
                )
            ))
            ->add('metaKeywords')
            ->add('metaDescription')
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
            ->add('textArm')
            ->add('textRus')
            ->add('textEng')
            ->add('slug')
            ->add('position')
            ->add('metaKeywords')
            ->add('metaDescription')
        ;
    }
}
