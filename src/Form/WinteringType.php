<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Wintering;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class WinteringType extends AbstractType
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
            ->add('boat_name', null, [
                'label' => 'Nazwa jednostki: ',
            ])
            ->add('boat_length', null, [
                'label' => 'Długość: ',
            ])
            ->add('boat_width', null, [
                'label' => 'Szerokość: ',
            ])
            ->add('start_date', DateType::class, [
                'format' => 'dd MMMM y',
                'label' => 'Data początkowa: ',
                'data' => new \DateTime(), // today date
                'choice_translation_domain' => 'messages', // Tłumaczenie nazw miesięcy
            ])
            ->add('end_date', DateType::class, [
                'format' => 'dd MMMM y',
                'label' => 'Data końcowa: ',
                'data' => new \DateTime(), // today date
                'choice_translation_domain' => 'messages', // Tłumaczenie nazw miesięcy
            ])
            ->add('description', null, [
                'label' => 'Opis: ',
                // add style to hide field if user is not admin
                'attr' => [
                    'style' => !$isAdmin ? 'display: none;' : ''
                ],
                'label_attr' => [
                    'style' => !$isAdmin ? 'display: none;' : ''
                ]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Wintering::class,
        ]);
    }
}
