<?php

namespace App\Controller\Admin;

use App\Entity\Positions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class PositionsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Positions::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Positions')
            ->setEntityLabelInPlural('Positions')
            ->setSearchFields(['id', 'Name']);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('deviceType'))
            ->add(EntityFilter::new('Location'));
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('Name');
        $location = AssociationField::new('Location');
        $deviceType = AssociationField::new('deviceType');
        $stockings = AssociationField::new('Stockings');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $location, $deviceType, $stockings];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name, $location, $deviceType, $stockings];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $location, $deviceType, $stockings];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $location, $deviceType, $stockings];
        }
    }
}
