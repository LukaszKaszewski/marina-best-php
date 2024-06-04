<?php

namespace App\Form;

use App\Entity\Service;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class ServiceType extends AbstractType
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
            ->add('user_id', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username',
                'label' => 'Użytkownik: ',

                // add style to hide field if user is not admin
                'attr' => [
                    'style' => !$isAdmin ? 'display: none;' : ''
                ],
                'label_attr' => [
                    'style' => !$isAdmin ? 'display: none;' : ''
                ]
            ])
            ->add('energy', CheckboxType::class, [
                'label' => 'Energia: ',
                'required' => false,
            ])
            ->add('fuel', CheckboxType::class, [
                'label' => 'Paliwo: ',
                'required' => false,
            ])
            ->add('water', CheckboxType::class, [
                'label' => 'Woda: ',
                'required' => false,
            ])
            ->add('waste', CheckboxType::class, [
                'label' => 'Odpady: ',
                'required' => false,
            ])
            ->add('crane',  CheckboxType::class, [
                'label' => 'Dźwig: ',
                'required' => false,
            ])
            ->add('date', DateType::class, [
                'format' => 'dd MMMM y',
                'label' => 'Data: ',
                'data' => new \DateTime(), // today date
                'choice_translation_domain' => 'messages', // day translation
            ])
            ->add('boat_name', null, [
                'label' => 'Nazwa jednostki: ',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
