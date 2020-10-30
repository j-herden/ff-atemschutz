<?php

namespace App\Controller\Admin;

use App\Entity\Organisation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OrganisationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Organisation::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Organisation')
            ->setEntityLabelInPlural('Organisation')
            ->setSearchFields(['id', 'Name', 'color']);
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('Name');
        $color = TextField::new('color');
        $locations = AssociationField::new('locations');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $color, $locations];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name, $color, $locations];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $color, $locations];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $color, $locations];
        }
    }
}
