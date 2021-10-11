<?php

namespace App\Form;

use App\Entity\Newsletters\NewsLetters;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewslettersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,            
            [
                'label'=> 'Auteur',
       
            ])
            ->add('content', HiddenType::class)
            //  ->add('categories', EntityType::class, [
            //      'class' => Categories::class,
            //      'choice_label' => 'name'
            //  ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NewsLetters::class,
        ]);
    }
}
