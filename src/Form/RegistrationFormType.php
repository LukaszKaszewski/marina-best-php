<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nazwa użytkownika',
            ])
            ->add('name', TextType::class, [
                'label' => 'Imię',
            ])
            ->add('surname', TextType::class, [
                'label' => 'Nazwisko',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adres e-mail',
            ])
            ->add('phone', TextType::class, [
                'label' => 'Nr telefonu',
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'Akceptuję warunki',
                'mapped' => false,
//                'constraints' => [
//                    new IsTrue([
//                        'message' => 'Zaakceptuj warunki.',
//                    ]),
//                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => 'Hasło',
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
//                    new NotBlank([
//                        'message' => 'Please enter a password',
//                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Hasło powinno zawierać minimum {{ limit }} znaków',
                        'max' => 30,
                        'maxMessage' => 'Hasło powinno zawierać maksimum {{ limit }} znaków',
                    ]),
                ],
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
