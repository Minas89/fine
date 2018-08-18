<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname',TextType::class,array(
                'constraints' => array(new NotBlank(
                    array('message' =>'register_form.mandatory_field', )
                )),
            ))
            ->add('lastname',TextType::class,array(
                'constraints' => array(new NotBlank(
                    array('message' =>'register_form.mandatory_field', )
                )),
            ))
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
                'constraints' => array(new NotBlank(
                    array('message' =>'register_form.mandatory_field', )
                )),
            ))
            ->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle'))
            ->add('email', 'email', array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',
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
