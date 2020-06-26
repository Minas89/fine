<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
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

class RegisterType2 extends AbstractType
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



            ->add('emailNots', CheckboxType::class, array(
                    'mapped' => false,
                    'label' => false,
                    'attr' => ['class' => 'pull-left mr10 fs16'],
                    //'constraints' => new IsFalse(),
                    )
            )

            ->add('dateOfBirth',BirthdayType::class,array(
                'widget'=> 'choice',
                'placeholder' => array(
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                ),
                'constraints' => array(new NotBlank(
                    array('message' =>'register_form.mandatory_field', )
                )),
            ))
            ->add('gender',ChoiceType::class,array(
                'choices' => array(
                    'f' => 'Female',
                    'm' => 'Male',
                    'u' => 'Prefer not to naswer'
                ),
                'multiple' => false,
                'expanded' => true,
                'required' => true,
               // 'choices_as_values' => true,
                'constraints' => array(new NotBlank(
                    array('message' =>'register_form.mandatory_field', )
                )),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_register_type2';
    }
}
