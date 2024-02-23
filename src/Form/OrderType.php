<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
             // Champ caché pour le token Stripe
            //  ->add('stripeToken', HiddenType::class, [
            //     'mapped' => false, // Pour ne pas mapper ce champ à une propriété de l'entité Order
            // ])
            // ->add('Ref')
            ->add('address')
            ->add('addressComplement')
            ->add('zipCode')
            ->add('city')
            // ->add('phoneNumber')
            // ->add('billingAddress')
            // ->add('billingAddressComplement')
            // ->add('billingZipCode')
            // ->add('billingCity')
//             ->add('user', EntityType::class, [
//                 'class' => User::class,
// 'choice_label' => 'firstname',
//             ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
