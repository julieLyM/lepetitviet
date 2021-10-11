<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

    
        ->add('email', EmailType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => "merci de saisir une adresse email"
                ])
            ],
            'required' => true,
            'attr' => [
                'class' => 'form-control'
            ]
            ])
        ->add('password')

        ->add('roles', ChoiceType::class,[
            'choices' => [
                'Utilisateur' => 'ROLE_USER',
                'Editor' => 'ROLE_EDITOR',
                'Admin' => 'ROLE_ADMIN'
            ],
            'expanded' => true,
            'multiple' => true,
            'label' => 'Rôles'
        ])
        ->add('lastname', TextType::class,[
            'label'=> 'Votre nom',
            'required' => true,
            'constraints'=> new Length([
                'min'=>2,
                'max'=>30
            ]),
        ])        ->add('firstname',TextType::class,[
            'label'=> 'Votre prenom',
            'required'=>true,
            'constraints'=>
                new Length([
                'min'=>2,
                'max'=>30
            ]),

        ])
        ->add('adress',TextType::class, [
            'label'=>'Votre adresse',
            // 'attr'=>[
            //     'placeholder'=>'8 rue des lilas...'
            // ]
        ] )
        ->add('zipcode',TextType::class, [
            'label'=>'Votre code postal',
            // 'attr'=>[
            //     'placeholder'=>'Entre votre code postal'
            // ]
        ] )
        ->add('city',TextType::class, [
            'label'=>'Votre ville',
      
        ] )
  
        ->add('phone',TelType::class, [
            'label'=>'Votre telephone',
            'required' => true,
            'constraints'=>
                new Length([
                    'min'=>2,
                    'max'=>10
                ]),
        ])
        // ->add('birthday', BirthdayType::class, [
        //     'label'=> "Votre date de naissance",
        //     'widget' => 'single_text',
        // ])
        ;
}


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
