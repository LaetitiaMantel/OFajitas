<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Event\PreSetDataEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('password', PasswordType::class, [
            //     'label' => 'Mot de passe'
            // ])
            // REFER : https://symfony.com/doc/6.4/form/events.html#event-listeners
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                [$this, 'onPreSetData'])

            ->add('isBanned', CheckboxType::class, [
                'label' => 'Ce client est-il banni?',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    public function onPreSetData(PreSetDataEvent $event): void
    {
        // cet évènement intervient entre la création et le handle du formulaire
        //  $form = $this->createForm(UserType::class, $user);
        // on récupère le corps du formulaire (UserType::class)
        $form = $event->getForm();
        // on récupère l'user du formulaire ($user)
        $user = $event->getData();

        // si l'user est null c'est qu'on est en création
        if ($user->getId() === null) {
            $form->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'empty_data'    => '',
            ]);
        } else
        // sinon on est en modification
        {
            $form->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'empty_data'    => '',
                // REFER : https://symfony.com/doc/6.4/reference/forms/types/password.html#mapped
                // Ce champ n'est plus mappé entre le formulaire et l'entité
                // les modifications faites dans le formulaire ne seront pas directement répercutées dans l'entité
                'mapped'        => false,
                'attr'          => [
                    'placeholder'   => 'Laissez vide si le mot de passe est inchangé',
                ],
            ]);
        }
    }
}
