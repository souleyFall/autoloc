<?php

namespace App\Controller\Admin;

use App\Entity\Car;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CarCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Car::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Voiture')
            ->setEntityLabelInPlural('Voitures');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            ImageField::new('photo')
                ->setLabel('Image')
                ->setUploadDir('public/uploads/images/voitures')
                ->setBasePath('uploads/images/voitures/')
                ->setUploadedFileNamePattern('[name]-[timestamp].[extension]'),
            TextField::new('brand')->setLabel('Marque'),
            TextField::new('model')->setLabel('Modèle'),
            NumberField::new('year')->setLabel('Année'),            
            NumberField::new('price')->setLabel('Prix'),
            BooleanField::new('available')->setLabel('Disponibilité'),
        ];
    }
}
