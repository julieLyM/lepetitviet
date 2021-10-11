<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('name', TextType::class, [
                'label'=>"Nom du produit"
            ])
            ->add('stock', ChoiceType::class, [
                'choices' => [
                    'Produit disponible' => true,
                    'Produit Non disponible' => false,
                ],
            ])
            ->add('category', EntityType::class,
            [
                'label' => 'Choisir une catégorie',
                'class' => Category::class,
                'choice_label' => 'name',
            ])
            ->add('description', TextareaType::class, [
                'label'=>"Description du produit",
            ])
            ->add('reference', TextareaType::class, [
                'label'=>"Reference du produit",
            ])
            //->add('quantity', HiddenType::class)
            ->add('price',MoneyType::class, [
                'label'=>"Prix",
                'required'=>false,
            ])

            ->add('image',FileType::class,[
                'label'=>"Image produit",
                'required'=>false,
                'data_class' => null,
                'empty_data' => ''
            ])
            ->add('submit', SubmitType::class, [
                'label'=>'Enregistrer / modifier le produit ',
                'attr'=>[
                    'class'=>'btn btn-block btn-outline-secondary'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
