<?php

namespace App\Controller;

use App\Repository\StockingsRepository;
use \Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


final class MaintenanceController extends AbstractController
{
    #[Route('/maintenance{type}', name: 'maintenance')]

    public function index(StockingsRepository $stockingsRepo, Pdf $snappy, string $type = '')
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $stockings  = $stockingsRepo->findMaintenance();

        if ($type === ".pdf") {
            $html = $this->renderView('maintenance/index.html.twig', [
                'stockings' => $stockings,
            ]);

            $pdf = $snappy->getOutputFromHtml($html);
            return new Response(
                $pdf,
                200,
                [
                    'Content-Type'          => 'application/pdf',
                    'Content-Disposition'   => 'attachment; filename="Atemschutz-Prüftermine.pdf"'
                ]
            );
        }

        return $this->render('maintenance/index.html.twig', [
            'stockings' => $stockings,
        ]);
    }
}
