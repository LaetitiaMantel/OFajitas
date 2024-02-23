<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Order;
use Faker\Core\Number;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

class OrderType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Champ caché pour le token Stripe
            // ->add('stripeToken', HiddenType::class, [
            //     'mapped' => false, // Pour ne pas xmapper ce champ à une propriété de l'entité Order
            // ])
            // ->add('Ref')
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
            ->add('useDifferentDeliveryAddress', CheckboxType::class, [
                'label' => 'Adresse de livraison ',
                'required' => false,
                'attr' => ['class' => 'billingCheckbox'],
                'mapped' => false,
            ])
            ->add('billingAddress', HiddenType::class,  [
                'label' => 'Adresse de facturation',
                'attr' => ['class' => 'billingAddressFields'],
            ])
            ->add('billingAddressComplement', HiddenType::class, [
                'label' => 'Complément d\'adresse de facturation',
                'attr' => ['class' => 'billingAddressFields'],
            ])
            ->add('billingZipCode', HiddenType::class, [
                'label' => 'Code postal de facturation',
                'attr' => ['class' => 'billingAddressFields'],
            ])
            ->add('billingCity', HiddenType::class, [
                'label' => 'Ville de facturation',
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
