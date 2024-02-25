<?php

namespace App\Form;

use App\Entity\Place;
use App\Entity\Rfid;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class Place1Type extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
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
            ->add('keyNumber', EntityType::class, [
                'class' => Rfid::class,
                'choice_label' => 'number',
                'label' => 'Numer klucza: ',
                // add style to hide field if user is not admin
                'attr' => [
                    'style' => !$isAdmin ? 'display: none;' : ''
                ],
                'label_attr' => [
                    'style' => !$isAdmin ? 'display: none;' : ''
                ]
            ])
            ->add('number', null, [
                'label' => 'Nr miejsca: ',
            ])
            ->add('start_date', DateType::class, [
                'format' => 'dd MMMM y',
                'label' => 'Data początkowa',
            ])
            ->add('end_date', DateType::class, [
                'format' => 'dd MMMM y',
                'label' => 'Data końcowa',
            ])
            ->add('boat_name');
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Place::class,
        ]);
    }
}
