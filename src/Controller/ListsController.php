<?php

namespace App\Controller;

use App\Repository\StockingsRepository;
use \Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListsController extends AbstractController
{
    /**
     * @Route("/lists{type}", name="lists")
     */
    public function index(string $type = '', StockingsRepository $stockingsRepo, Pdf $snappy)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $stockings  = $stockingsRepo->findCurrent();

        if ( $type === ".pdf" )
        {
            $html = $this->renderView('lists/index.html.twig', [
                'stockings' => $stockings,
            ]);

            $pdf = $snappy->getOutputFromHtml( $html );
            return new Response(
                $pdf, 200, [
                    'Content-Type'          => 'application/pdf',
                    'Content-Disposition'   => 'attachment; filename="Atemschutz-Dashboard.pdf"'
            ]);
        }

        return $this->render('lists/index.html.twig', [
            'stockings' => $stockings,
        ]);
    }

}
