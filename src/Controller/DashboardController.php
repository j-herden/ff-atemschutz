<?php

namespace App\Controller;

use App\Entity\DeviceTypes;
use App\Entity\Location;
use App\Entity\Postions;
use App\Entity\Stockings;
use App\Repository\OrganisationRepository;
use App\Repository\PositionsRepository;
use App\Repository\DeviceTypesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(Request $request, OrganisationRepository $organisationRepo, PositionsRepository $positionsRepo, DeviceTypesRepository $deviceTypesRepo, SessionInterface $session)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $this->addStocking($request, $positionsRepo);

        // settings
        $showForms    = $session->get('dashboard.showForms', true);
        $maxStockings = $session->get('dashboard.maxStockings', 3);
        $deviceId     = $session->get('dashboard.deviceId', 0);
        if ( ! is_null( $request->request->get('buttonSettings') ) )
        {
            $showForms = ( $request->request->get('showForms') === 'on' );

            $formMaxStockings = $request->request->get('maxStockings');
            if ( ! is_null( $formMaxStockings ) )
            {
                $maxStockings = intval( $formMaxStockings );
            }

            $formDeviceId = $request->request->get('deviceTypeId');
            if ( ! is_null( $formDeviceId ) )
            {
                $deviceId = intval( $formDeviceId );
            }
        }

        $organisations = $organisationRepo->findAll();
        $deviceTypes = $deviceTypesRepo->findAll();

        $session->set('dashboard.showForms',    $showForms);
        $session->set('dashboard.maxStockings', $maxStockings);
        $session->set('dashboard.deviceId',     $deviceId);

        return $this->render('dashboard/index.html.twig', [
            'organisations' => $organisations,
            'deviceTypes'   => $deviceTypes,
            'showForms'     => $showForms,
            'deviceId'      => $deviceId,
            'maxStockings'  => $maxStockings,
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
        $stocking->setUser( $this->getUser() );

        $position->addStocking($stocking);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($stocking);
        $entityManager->flush();
    }
}
