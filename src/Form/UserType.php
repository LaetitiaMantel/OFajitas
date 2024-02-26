<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',  EmailType::class, [
                'label' => 'Adresse Email',
                'empty_data'    => '',
            ])

            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe'
            ])
            // ->add('roles', ChoiceType::class, [
            //     'choices' => [
            //         'Admin' => 'ROLE_ADMIN',
            //         'Manager' => 'ROLE_MANAGER',
            //         // Add other roles as needed
            //     ],
            //     'multiple' => true, // Allow selecting multiple roles
            //     'expanded' => true, // Display roles as checkboxes
            // ])
            ->add('roles', ChoiceType::class, [
                'multiple'      => false,
                'expanded'      => true,
                'choices'       => [
                    'administrateur'    => 'ROLE_ADMIN',
                    'manager'           => 'ROLE_MANAGER',
                ],
                'empty_data'    => '',
                'label_attr'    => [
                    'class'     => 'checkbox-inline',
                ],
            ])
            
            ->add('firstname', TextType::class, [
                'label'         => "Prénom de l'utilisateur",
                'empty_data'    => '',
            ])
            ->add('lastname', TextType::class, [
                'label'         => "Nom de l'utilisateur",
                'empty_data'    => '',
            ])
            // REFER : https://symfony.com/doc/current/form/data_transformers.html#example-1-transforming-strings-form-data-tags-from-user-input-to-an-array
            ->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($tagsAsArray): string {
                    // transform the array to a string
                    return implode(', ', $tagsAsArray);
                },
                function ($tagsAsString): array {
                    // transform the string back to an array
                    return explode(', ', $tagsAsString);
                }
            ));

            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
