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
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
   /**
     * @Route("/admin")
     */
    public function index(): Response
    {
        // redirect to some CRUD controller
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();

        return $this->redirect($routeBuilder->setController(StockingsCrudController::class)->generateUrl());
    }
    
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('EasyAdmin');
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
        yield MenuItem::linkToCrud('Stockings', 'fas fa-location-arrow', Stockings::class);
        yield MenuItem::linkToCrud('Positions', 'fas fa-box', Positions::class);
        yield MenuItem::linkToCrud('Location', 'fas fa-map-marker-alt', Location::class);
        yield MenuItem::linkToCrud('Organisation', 'fas fa-sitemap', Organisation::class);
        yield MenuItem::linkToCrud('DeviceTypes', 'fas fa-tools', DeviceTypes::class);
        yield MenuItem::linkToCrud('User', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('ResetPasswordRequest', 'fas fa-unlock', ResetPasswordRequest::class);
        yield MenuItem::linktoRoute('Dashboard', 'fas fa-tachometer-alt', 'dashboard');
    }
}
