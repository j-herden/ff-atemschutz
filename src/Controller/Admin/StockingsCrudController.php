<?php

namespace App\Controller\Admin;

use App\Entity\Stockings;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class StockingsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Stockings::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Stockings')
            ->setEntityLabelInPlural('Stockings')
            ->setSearchFields(['id', 'device_id']);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('position'))
            ->add(EntityFilter::new('user'));
    }

    public function configureFields(string $pageName): iterable
    {
        $date = DateField::new('date');
        $deviceId = TextField::new('device_id');
        $removed = Field::new('removed');
        $position = AssociationField::new('position');
        $user = AssociationField::new('user');
        $id = IntegerField::new('id', 'ID');
        $created = DateTimeField::new('created');
        $updated = DateTimeField::new('updated');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $date, $deviceId, $removed, $position, $user, $updated, $created];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $date, $deviceId, $removed, $created, $updated, $position, $user];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$date, $deviceId, $removed, $position, $user];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$date, $deviceId, $removed, $position, $user];
        }
    }
}
