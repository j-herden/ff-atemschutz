<?php

namespace App\Controller\Admin;

use App\Entity\ResetPasswordRequest;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ResetPasswordRequestCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ResetPasswordRequest::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('ResetPasswordRequest')
            ->setEntityLabelInPlural('ResetPasswordRequest')
            ->setSearchFields(['id', 'selector', 'hashedToken']);
    }

    public function configureFields(string $pageName): iterable
    {
        $selector = TextField::new('selector');
        $hashedToken = TextField::new('hashedToken');
        $requestedAt = DateTimeField::new('requestedAt');
        $expiresAt = DateTimeField::new('expiresAt');
        $user = AssociationField::new('user');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $user, $requestedAt, $expiresAt];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $selector, $hashedToken, $requestedAt, $expiresAt, $user];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$selector, $hashedToken, $requestedAt, $expiresAt, $user];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$selector, $hashedToken, $requestedAt, $expiresAt, $user];
        }
    }
}
