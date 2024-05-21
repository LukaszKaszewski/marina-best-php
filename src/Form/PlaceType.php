<?php

namespace App\Form;

use App\Entity\Place;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class PlaceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
//            ->add('number')
//            ->add('size')
            ->add('start_date', DateType::class, [
                'format' => 'dd MMMM y', // Ustaw format daty
                'label' => 'Data początkowa', // Ustaw etykietę pola
                'attr' => ['class' => 'datepicker'], // class to style the field

            ])
            ->add('end_date', DateType::class, [
                'format' => 'dd MMMM y', // Ustaw format daty
                'label' => 'Data zakończenia postoju', // Ustaw etykietę pola
                'attr' => ['class' => 'datepicker'], // class to style the field
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Place::class,
        ]);
    }
}
