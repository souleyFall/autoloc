<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\Reservation;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reservedFrom', DateType::class, [
                'widget' => 'single_text', // rend un champ <input type="date">
                'label' => 'Début de la réservation',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true,
            ])
            ->add('reservedTo', DateType::class, [
                'widget' => 'single_text', // rend un champ <input type="date">
                'label' => 'Fin de la réservation',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true,
            ])
            ->add('valider', SubmitType::class, [
                'label' => 'réserver',
                'attr' => [
                    'class' => 'btn btn-primary mt-2',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
