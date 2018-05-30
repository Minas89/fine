<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class TextsAdmin extends AbstractAdmin
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
            ->add('id')
            ->add('titleArm')
            ->add('titleRus')
            ->add('titleEng')
            ->add('slug')
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
