<?php

namespace App\Controller;

use App\Entity\DeviceTypes;
use App\Entity\Location;
use App\Entity\Postions;
use App\Entity\Stockings;
use App\Repository\DeviceTypesRepository;
use App\Repository\OrganisationRepository;
use App\Repository\PositionsRepository;
use App\Repository\StockingsRepository;
use Doctrine\Persistence\ManagerRegistry;
use \Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    private $managerRegistry;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->managerRegistry = $doctrine;
    }

    #[Route(path: '/dashboard{type}', name: 'dashboard')]

    public function index(Request $request, OrganisationRepository $organisationRepo
                        , PositionsRepository $positionsRepo, DeviceTypesRepository $deviceTypesRepo
                        , SessionInterface $session, StockingsRepository $stockingsRepo
                        , Pdf $snappy, string $type = '')
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $submittedToken = $request->request->get('token');

        // settings
        $showForms    = $session->get('dashboard.showForms', true);
        $maxStockings = $session->get('dashboard.maxStockings', 3);
        $deviceTypeId = $session->get('dashboard.deviceTypeId', 0);
        $deviceFilter = $session->get('dashboard.deviceFilter', '');
        if ($this->isCsrfTokenValid('change-settings', $submittedToken))
        {
            $showForms = ( $request->request->get('showForms') === 'on' );

            $formMaxStockings = $request->request->get('maxStockings');
            if ( ! is_null( $formMaxStockings ) )
            {
                $maxStockings = intval( $formMaxStockings );
            }

            $formDeviceTypeId = $request->request->get('deviceTypeId');
            if ( ! is_null( $formDeviceTypeId ) )
            {
                $deviceTypeId = intval( $formDeviceTypeId );
            }

            $formDeviceFilter = $request->request->get('deviceFilter');
            if ( ! is_null( $formDeviceFilter ) )
            {
                $deviceFilter = $formDeviceFilter;
            }
        }
        elseif ($this->isCsrfTokenValid('add-stocking', $submittedToken))
        {
            $this->addStocking($request, $positionsRepo, $stockingsRepo);
        }
        elseif ($this->isCsrfTokenValid('remove-stocking', $submittedToken))
        {
            $this->removeStocking($request, $stockingsRepo);
        }


        $organisations = $organisationRepo->findAll();
        $deviceTypes = $deviceTypesRepo->findAll();

        $session->set('dashboard.showForms',    $showForms);
        $session->set('dashboard.maxStockings', $maxStockings);
        $session->set('dashboard.deviceTypeId', $deviceTypeId);
        $session->set('dashboard.deviceFilter', $deviceFilter);

        if ( $type === '.pdf' )
        {
            $html = $this->renderView('dashboard/index.html.twig', [
                'organisations' => $organisations,
                'deviceTypes'   => $deviceTypes,
                'showForms'     => false,
                'deviceTypeId'  => $deviceTypeId,
                'maxStockings'  => $maxStockings,
                'deviceFilter'  => $deviceFilter,
            ]);

            $pdf = $snappy->getOutputFromHtml( $html );
            return new Response(
                $pdf, 200, [
                    'Content-Type'          => 'application/pdf',
                    'Content-Disposition'   => 'attachment; filename="Atemschutz-Dashboard.pdf"'
            ]);
        }

        return $this->render('dashboard/index.html.twig', [
            'organisations' => $organisations,
            'deviceTypes'   => $deviceTypes,
            'showForms'     => $showForms,
            'deviceTypeId'  => $deviceTypeId,
            'maxStockings'  => $maxStockings,
            'deviceFilter'  => $deviceFilter,
        ]);
    }

    private function removeStocking(Request $request, StockingsRepository $stockingsRepo)
    {
        $stockingId = intval( $request->request->get('stockingId') );
        if ( ! $stockingId )
        {
            $this->addFlash('error', __METHOD__ . " Formulardaten fehlerhaft");
            return;
        }

        $stocking = $stockingsRepo->find($stockingId);
        if ( ! $stocking )
        {
            $this->addFlash('error', __METHOD__ . " Stocking mit Id $stockingId nicht gefunden");
            return;
        }
        $stocking->setRemoved( true );

        $entityManager = $this->managerRegistry->getManager();
        // $entityManager->persist($stocking);
        $entityManager->flush();
    }

    private function addStocking(Request $request, PositionsRepository $positionsRepo, StockingsRepository $stockingsRepo)
    {
        $deviceId    = $request->request->get('deviceId') ;
        $position_id = intval( $request->request->get('position_id') );
        $date        = $request->request->get('date');

        if ( is_null( $deviceId ) or is_null( $position_id ) or is_null( $date ) )
        {
            $this->addFlash('error', __METHOD__ . " Formulardaten fehlerhaft");
            return;
        }

        $dateObj = date_create_from_format('Y-m-d', $date);
        if ( $dateObj === false )
        {
            $this->addFlash('error', __METHOD__ . "Datum nicht verstanden");
            return;
        }

        if ( !  \is_numeric($position_id) )
        {
            $this->addFlash('error', __METHOD__ . "position_id nicht numerisch");
            return;
        }
        // position suchen
        $position = $positionsRepo->find($position_id);
        if ( ! $position )
        {
            $this->addFlash('error', __METHOD__ . "Position mit Id $position_id nicht gefunden");
            return;
        }
        // update or insert record
        $entityManager = $this->managerRegistry->getManager();

        $stocking = $stockingsRepo->findOneBy(['date'      => $dateObj,
                                               'device_id' => $deviceId,
                                               'position'  => $position,
                                              ]);
        if ( ! $stocking )
        {
            $stocking = new Stockings();
            $stocking->setDate($dateObj);
            $stocking->setDeviceId($deviceId);
            $position->addStocking($stocking);
            $entityManager->persist($stocking);
        }
        else {
            $position->setStockingsRemoved();
        }
        $stocking->setRemoved( false );
        $stocking->setUser( $this->getUser() );

        $entityManager->flush();
    }
}
