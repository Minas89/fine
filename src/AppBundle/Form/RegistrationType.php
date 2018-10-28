<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsFalse;
use Symfony\Component\Validator\Constraints\IsTrue;
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
                'label' => 'First Name'
            ))
            ->add('lastname',TextType::class,array(
                'constraints' => array(new NotBlank(
                    array('message' =>'register_form.mandatory_field', )
                )),
                'label' => 'Last Name'
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
            ->add('phone',TextType::class,array(
                'attr' => [
                    'class' => 'form-control phone'
                ],
                'constraints' => array(new NotBlank(
                    array('message' =>'register_form.mandatory_field', )
                )),

            ))
            ->add('termsAccepted', CheckboxType::class, array(
                'mapped' => false,
                'label' => false,
                'attr' => ['class' => 'pull-left mr10 fs16'],
                'constraints' => new IsTrue(),)
            )

            ->add('emailNots', CheckboxType::class, array(
                    'mapped' => false,
                    'label' => false,
                    'attr' => ['class' => 'pull-left mr10 fs16'],
                    'constraints' => new IsFalse(),)
            )

            ->add('dateOfBirth',BirthdayType::class,array(

            ))
            ->add('gender',ChoiceType::class,array(
                'choices' => array(
                    'f' => 'Female',
                    'm' => 'Male',
                    'u' => 'Prefer not to naswer'
                ),
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
