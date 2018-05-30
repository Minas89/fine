<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use AppBundle\Entity\Categories;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CategoriesAdmin extends AbstractAdmin
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
            ->add('metaKeywords')
            ->add('metaDescription')
            ->add('parent')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('titleArm',null,array(
                'editable' => true
            ))
            ->add('titleRus',null,array(
                'editable' => true
            ))
            ->add('titleEng',null,array(
                'editable' => true
            ))
            ->add('slug',null,array(
                'editable' => true
            ))
            ->add('position',null,array(
                'editable' => true
            ))
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
            ->add('parent')
            ->add('type',ChoiceType::class,array(
                'choices' => array(
                    'Artist' => Categories::ArtistType,
                    'Creator' => Categories::CreatorType,
                    'Designer' => Categories::DesignerType
                ),
                'choices_as_values' => true,
                'required' => false,
                'help' => 'For shopping, ex. Shop by Artists'
            ))
            ->add('titleArm')
            ->add('titleRus')
            ->add('titleEng')
            ->add('slug')
            ->add('textArm',CKEditorType::class)
            ->add('textRus',CKEditorType::class)
            ->add('textEng',CKEditorType::class)
            ->add('position')
            ->add('image','sonata_type_model_list',array(),array(
                'link_parameters' => array(
                    'context' => 'categories'
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
            ->add('slug')
            ->add('position')
            ->add('metaKeywords')
            ->add('metaDescription')
        ;
    }
}
