<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;

class ReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Réservation')
            ->setEntityLabelInPlural('Réservations');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('car')->setLabel('Voiture réservée'),
            AssociationField::new('user')->setLabel('Client'),
            DateField::new('reservedFrom')->setLabel('Début'),
            DateField::new('reservedTo')->setLabel('Fin'),
        ];
    }
}
