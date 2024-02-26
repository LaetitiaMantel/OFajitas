<?php

namespace App\Form;

use App\Entity\User;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Event\PreSetDataEvent;
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


            // ->add('password', PasswordType::class, [
            //     'label' => 'Mot de passe'
            // ])
            // REFER : https://symfony.com/doc/6.4/form/events.html#event-listeners
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                [$this, 'onPreSetData'])


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
