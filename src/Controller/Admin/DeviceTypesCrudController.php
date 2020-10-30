<?php

namespace App\Controller\Admin;

use App\Entity\DeviceTypes;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DeviceTypesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DeviceTypes::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('DeviceTypes')
            ->setEntityLabelInPlural('DeviceTypes')
            ->setSearchFields(['id', 'Name', 'color']);
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('Name');
        $color = TextField::new('color');
        $positions = AssociationField::new('positions');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $color, $positions];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name, $color, $positions];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $color, $positions];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $color, $positions];
        }
    }
}
