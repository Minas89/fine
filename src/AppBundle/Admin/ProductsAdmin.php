<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class ProductsAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('titleArm')
            ->add('titleRus')
            ->add('titleEng')
            ->add('slug')
            ->add('position')
            ->add('price')
            ->add('new')
            ->add('top')
            ->add('sale')
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
            ->add('top',null,array(
                'editable' => true
            ))
            ->add('sale',null,array(
                'editable' => true
            ))
            ->add('new',null,array(
                'editable' => true
            ))
            ->add('position',null,array(
                'editable' => true
            ))
            ->add('price',null,array(
                'editable' => true
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
            ->add('category')
            ->add('creator')
            ->add('titleArm')
            ->add('titleRus')
            ->add('titleEng')
            ->add('textArm',CKEditorType::class)
            ->add('textRus',CKEditorType::class)
            ->add('textEng',CKEditorType::class)
            ->add('year')
            ->add('price')
            ->add('slug')
            ->add('position')
            ->add('new')
            ->add('top')
            ->add('sale')
            ->add('width')
            ->add('height')
            ->add('details','sonata_type_collection',
                array('by_reference' => false),
                array('edit' => 'inline',
                    'inline' => 'table',
                    'sortable'  => 'position',
                )
            )
            ->add('colors')
            ->add('image','sonata_type_model_list',array(),array(
                'link_parameters' => array(
                    'context' => 'products'
                )
            ))
            ->add('gallery','sonata_type_model_list',array(),array(
                'link_parameters' => array(
                    'context' => 'productsGallery'
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
            ->add('new')
            ->add('top')
            ->add('sale')
            ->add('price')
            ->add('position')
            ->add('metaKeywords')
            ->add('metaDescription')
        ;
    }
}
