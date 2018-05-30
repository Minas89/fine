<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class BlogsAdmin extends AbstractAdmin
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
            ->add('slug')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('titleArm')
            ->add('titleRus')
            ->add('titleEng')
            ->add('textArm')
            ->add('textRus')
            ->add('textEng')
            ->add('slug')
            ->add('position')
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
            ->add('titleRus')
            ->add('titleEng')
            ->add('textArm',CKEditorType::class)
            ->add('textRus',CKEditorType::class)
            ->add('textEng',CKEditorType::class)
            ->add('slug')
            ->add('position')
            ->add('image','sonata_type_model_list',array(),array(
                'link_parameters' => array(
                    'context' => 'blogs'
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
            ->add('created')
        ;
    }
}
