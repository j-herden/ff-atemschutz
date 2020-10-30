<?php

namespace App\Controller\Admin;

use App\Entity\Location;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class LocationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Location::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Location')
            ->setEntityLabelInPlural('Location')
            ->setSearchFields(['id', 'Name']);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('organisation'));
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('Name');
        $organisation = AssociationField::new('organisation');
        $positions = AssociationField::new('positions');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $organisation, $positions];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name, $organisation, $positions];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $organisation, $positions];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $organisation, $positions];
        }
    }
}
