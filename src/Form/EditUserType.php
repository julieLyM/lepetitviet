<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

    //         ->add('password')
    //         ->add('lastname')
    //         ->add('firstname')
    //         ->add('adress')
    //         ->add('zipcode')
    //         ->add('city')
    //         ->add('phone')
    //         ->add('createdAt')
    //         ->add('updatedAt')
    //         ->add('image')
    //         ->add('birthday')
    //         ->add('isVerified')
    //     ;
    // }

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
    ->add('Valider', SubmitType::class)

;
}


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
