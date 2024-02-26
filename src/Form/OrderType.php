<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TelType;



class OrderType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('Firstname', TextType::class, [
                'mapped' => false,
                'required' => true,
                'label' => 'Prénom',
                'data' => ucfirst(($options['user'] instanceof User) ? $options['user']->getFirstName():null)
            ])
            // ucfirst : capitalize la premiere lettre 
            ->add('Lastname', TextType::class, [
                'mapped' => false,
                'required' => true,
                'label' => 'Nom de famille',
                'data' => ucfirst(($options['user'] instanceof User) ? $options['user']->getLastName():null)
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'required' => true,
            ])
            ->add('addressComplement', TextType::class, [
                'label' => 'Complément d\'adresse',
                'required' => false,
            ])
            ->add('zipCode', TextType::class, [
                'label' => 'Code postal',
                'required' => true,
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'required' => true,
            ])
            ->add('phoneNumber', TelType::class, [
                'label' => 'Numéro de téléphone',
                'required' => true,
            ])
            ->add('useDifferentDeliveryAddress', CheckboxType::class,  [
                'label' => 'Adresse de livraison différente',
                'required' => false,
                'attr' => ['class' => 'billingCheckbox'],
                'mapped' => false,
            ])
            ->add('billingAddress', TextType::class,  [
                'label' => 'Adresse ',
                'required' => false,
                'attr' => ['class' => 'billingAddressFields'],
            ])

            ->add('billingAddressComplement', TextType::class,  [
                'label' => 'Complément d\'adresse ',
                'required' => false,
                'attr' => ['class' => 'billingAddressFields'],
            ])

            ->add('billingZipCode', TextType::class, [
                'label' => 'Code postal',
                'required' => false,
                'attr' => ['class' => 'billingAddressFields'],
            ])

            ->add('billingCity', TextType::class, [
                'label' => 'Ville ',
                'required' => false,
                'attr' => ['class' => 'billingAddressFields'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
            'user' => null,
        ]);
    }


   
}
