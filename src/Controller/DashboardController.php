<?php

namespace App\Controller;

use App\Entity\DeviceTypes;
use App\Entity\Location;
use App\Entity\Postions;
use App\Entity\Stockings;
use App\Repository\OrganisationRepository;
use App\Repository\PositionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(Request $request, OrganisationRepository $organisationRepo, PositionsRepository $positionsRepo)
    {
        $this->addStocking($request, $positionsRepo);

        $organisations = $organisationRepo->findAll();

        return $this->render('dashboard/index.html.twig', [
            'organisations' => $organisations,
            'showForms'     => true,
            'deviceId'      => 0,
            'maxStockings'  => 6,
        ]);
    }

    private function addStocking(Request $request, PositionsRepository $positionsRepo)
    {
        $deviceId    = $request->request->get('deviceId');
        $position_id = $request->request->get('position_id');
        $date        = $request->request->get('date');

        if ( ! $deviceId or ! $position_id or ! $date )
        {
            return;
        }

        $dateObj = date_create_from_format('Y-m-d', $date);
        if ( $dateObj === false )
        {
            $this->addFlash('warning', "Datum nicht verstanden");
            return;
        }


        if ( !  \is_numeric($position_id) )
        {
            $this->addFlash('warning', "position_id nicht numerisch");
            return;
        }
        // position suchen
        $position = $positionsRepo->find($position_id);
        if ( ! $position )
        {
            $this->addFlash('warning', "Position mit Id $position_id nicht gefunden");
            return;
        }

        $stocking = new Stockings();
        $stocking->setDate($dateObj);
        $stocking->setDeviceId($deviceId);

        $position->addStocking($stocking);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($stocking);
        $entityManager->flush();
    }
}
