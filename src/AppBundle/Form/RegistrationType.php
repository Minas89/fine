<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('title',ChoiceType::class,array(
                'choices' => array(
                    'MR.' => 'mr',
                    'MRS.' => 'mrs',
                    'MS.' => 'ms',
                ),
                'multiple' => false,
                'expanded' => true,
                'required' => true,
                'choices_as_values' => true,
            ))
        ;
    }

    public function getParent()
    {
        return "fos_user_registration";
    }

    public function getName()
    {
        return 'register';
    }
}
