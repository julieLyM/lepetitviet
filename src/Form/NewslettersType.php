<?php

namespace App\Form;

use App\Entity\Newsletters\Categories;
use App\Entity\Newsletters\NewsLetters;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
                'label'=> 'Ecrit par :',
       
            ])
            ->add('categories', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'name'
             ])
            ->add('content', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NewsLetters::class,
        ]);
    }
}
