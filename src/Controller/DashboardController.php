<?php

namespace App\Controller;

use App\Entity\DeviceTypes;
use App\Entity\Location;
use App\Entity\Postions;
use App\Entity\Stockings;
use App\Repository\OrganisationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(OrganisationRepository $organisationRepo)
    {
        $organisations = $organisationRepo->findAll();

        //             ->currentByOrganisation();

        return $this->render('dashboard/index.html.twig', [
            'organisations' => $organisations,
        ]);
    }
}
