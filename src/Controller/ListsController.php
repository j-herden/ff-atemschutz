<?php

namespace App\Controller;

use App\Repository\StockingsRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ListsController extends AbstractController
{
    /**
     * @Route("/lists{type}", name="lists")
     */
    public function index(string $type = '', StockingsRepository $stockingsRepo)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $stockings  = $stockingsRepo->findCurrent();

        if ( $type === ".pdf" )
        {
            $this->renderPdf($stockings);
        }

        return $this->render('lists/index.html.twig', [
            'stockings' => $stockings,
        ]);
    }


    private function renderPdf($stockings)
     {
         // Configure Dompdf according to your needs
         $pdfOptions = new Options();
         $pdfOptions->set('defaultFont', 'Arial');

         // Instantiate Dompdf with our options
         $dompdf = new Dompdf($pdfOptions);

         // Retrieve the HTML generated in our twig file
         $html = $this->renderView('lists/pdf.html.twig', [
             'stockings' => $stockings,
         ]);

         // Load HTML to Dompdf
         $dompdf->loadHtml($html);

         // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
         $dompdf->setPaper('A4', 'portrait');

         // Render the HTML as PDF
         $dompdf->render();

         // Output the generated PDF to Browser (force download)
         $dompdf->stream("Atemschutz-Listenansicht.pdf", [
             "Attachment" => true
         ]);
     }
}
