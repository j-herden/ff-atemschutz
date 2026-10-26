<?php

namespace App\Controller\Admin;

use App\Controller\Admin\StockingsCrudController;
use App\Entity\DeviceTypes;
use App\Entity\Location;
use App\Entity\Organisation;
use App\Entity\Positions;
use App\Entity\ResetPasswordRequest;
use App\Entity\Stockings;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    private $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    public function index(): Response
    {
        $url = $this->adminUrlGenerator
            ->setController(StockingsCrudController::class)
            //->setAction('edit')
            //->setEntityId(1)
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        // Usually it's better to call the parent method because that gives you a
        // user menu with some menu items already created ("sign out", "exit impersonation", etc.)
        // if you prefer to create the user menu from scratch, use: return UserMenu::new()->...
        return parent::configureUserMenu($user)
            ->setGravatarEmail( $user->getUserIdentifier() );
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin Atemschutz');
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            ->setDateFormat('ddMMyyyy')
            ->setDateTimeFormat('ddMMyyyy HH:mm')
            ->setTimeFormat('HH:mm');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkTo(StockingsCrudController::class, 'Stockings', 'fas fa-location-arrow');
        yield MenuItem::linkTo(PositionsCrudController::class, 'Positions', 'fas fa-box');
        yield MenuItem::linkTo(LocationCrudController::class, 'Location', 'fas fa-map-marker-alt');
        yield MenuItem::linkTo(OrganisationCrudController::class, 'Organisation', 'fas fa-sitemap');
        yield MenuItem::linkTo(DeviceTypesCrudController::class, 'DeviceTypes', 'fas fa-tools');
        yield MenuItem::linkTo(UserCrudController::class, 'User', 'fas fa-user');
        yield MenuItem::linkTo(ResetPasswordRequestCrudController::class, 'ResetPasswordRequest', 'fas fa-unlock');
        yield MenuItem::linktoRoute('Dashboard', 'fas fa-tachometer-alt', 'dashboard');
    }
}
