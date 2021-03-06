<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue as ConstraintsIsTrue;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
             ->add('firstname', TextType::class, [
                 'label'=> 'Votre prénom'
             ])
            ->add('lastname', TextType::class, [
                'label'=> 'Votre nom'
            ])
            ->add('email', EmailType::class, [
                'label'=> 'Votre email'
            ])
            ->add('message', TextareaType::class, [
                'label'=> 'Votre message',
                'attr' => ['rows' => 6],
            ])
            ->add('is_rgpd', CheckboxType::class, [
                'constraints' => [
                    new ConstraintsIsTrue([
                        'message' => 'Vous devez accepter la collecte de vos données personnelles'
                    ])
                ],
                    'label' => 'J\'accepte la collecte de mes données personnelles'
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver); // TODO: Change the autogenerated stub
    }
}
