<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class UserType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isAdmin = $this->security->isGranted('ROLE_ADMIN');

        $builder
            ->add('username', null, [
                'label' => 'Nazwa użytkownika: ',
                // add style to hide field if user is not admin
                'attr' => [
                    'style' => !$isAdmin ? 'display: none;' : ''
                ],
                'label_attr' => [
                    'style' => !$isAdmin ? 'display: none;' : ''
                ]

            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Rola: ',
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'User' => 'ROLE_USER',
                ],
                'multiple' => true, // multiple choices
                'expanded' => true, // radio button
                'required' => true, // one choice - minimum

                // add style to hide field if user is not admin
                'attr' => [
                    'style' => !$isAdmin ? 'display: none;' : ''
                ],
                'label_attr' => [
                    'style' => !$isAdmin ? 'display: none;' : ''
                ]
            ])
            ->add('password', null, [
                'label' => 'Hasło: ',
                ])
            ->add('name', null, [
                'label' => 'Imię: ',
            ])
            ->add('surname', null, [
                'label' => 'Nazwisko: ',
            ])
            ->add('email', null, [
                'label' => 'Adres mailowy: ',
            ])
            ->add('created_at', null, [
                'label' => 'Data utworzenia: ',
                'html5' => false, // HTML5 off, format error
                'format' => 'dd MMMM y HH mm',
                // add style to hide field if user is not admin
                'attr' => [
                    'style' => !$isAdmin ? 'display: none;' : ''
                ],
                'label_attr' => [
                    'style' => !$isAdmin ? 'display: none;' : ''
                ],
            ])
            ->add('phone', null, [
                'label' => 'Numer telefonu: ',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
