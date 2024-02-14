<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Product;
use App\Entity\Category;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label'         => 'Nom du produit',
                'empty_data'    => '',
            ])
            ->add('description', TextareaType::class, [
                'label'         => 'Déscription',
                'empty_data'    => '',
            ])
            ->add('picture', UrlType::class, [
                'label'         => "Url de l'image du produit",
                'empty_data'    => '',
                'attr'          => [
                    'placeholder'   => 'par exemple : https://...',
                ],
            ])
            ->add('price', IntegerType::class, [
                'label'         => 'Prix du produit en centimes',
                'empty_data'    => '0',
            ])
            ->add('rating', ChoiceType::class, [
                // REFER : https://symfony.com/doc/6.4/reference/forms/types/choice.html#placeholder
                'placeholder' => 'choisissez une option',
                'expanded' => false,
                'multiple' => false,
                'choices'  => [
                    'Excellent'         => 5,
                    'Très bon'          => 4,
                    'Bon'               => 3,
                    'Peut mieux faire'  => 2,
                    'A éviter'          => 1,
                ],
                'label' => "Note du produit",
            ])
            
            ->add('status', ChoiceType::class, [
                'expanded' => false,
                'multiple' => false,
                'choices'  => [
                    'Oui'         => true,
                    'Non'          => false,
                ],
                'label'         => 'Produit disponible',
                'empty_data'    => '',
            ])

            ->add('brand', EntityType::class, [
                'class' => Brand::class,
                'choice_label' => 'name',
                'label' => 'Marque'
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Catégorie'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
