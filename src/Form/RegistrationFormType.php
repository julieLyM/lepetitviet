<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('firstname',TextType::class,[
            'label'=> 'Votre prenom *',
            'required'=>true,
            'constraints'=>
                new Length([
                'min'=>2,
                'max'=>30
            ]),

        ])
        ->add('lastname', TextType::class,[
            'label'=> 'Votre nom *',
            'required' => true,
            'constraints'=> new Length([
                'min'=>2,
                'max'=>30
            ]),
        ])
        ->add('adress',TextType::class, [
            'label'=>'Votre adresse',

        ] )
        ->add('zipcode',TextType::class, [
            'label'=>'Votre code postal',

        ] )
        ->add('city',TextType::class, [
            'label'=>'Votre ville',
      
        ] )
  
        ->add('phone',TelType::class, [
            'label'=>'Votre telephone *',
            'required' => true,
            'constraints'=>
                new Length([
                    'min'=>2,
                    'max'=>10
                ]),
        ])
        ->add('email', EmailType::class, [
            'label'=> 'Votre email *',
            'constraints'=>
                new Length([
                'min'=>2,
                'max'=>30 
            ]),
        
        ])
        ->add('agreeTerms', CheckboxType::class, [
            'mapped' => false,
            'label'=> 'En créant votre compte, vous acceptez l\'intégralité de nos CGV et notre politique de protection des données personnelles.',
            'constraints' => [
                new IsTrue([
                    'message' => '',
                ]),
            ],
        ])
        ->add('plainPassword', PasswordType::class, [

            'mapped' => false,
            'required' => true,
            'attr' => ['autocomplete' => 'new-password'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Merci de remplir un mot de passe',
                ]),
                new Length([
                    'min' => 6,
                    'minMessage' => 'Votre mot de passe doit avoir un minimun de {{ limit }} caractères',
                    'max' => 4096,
                ]),
            ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
