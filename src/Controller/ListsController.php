<?php

namespace App\Controller;

use App\Repository\StockingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ListsController extends AbstractController
{
    /**
     * @Route("/lists", name="lists")
     */
    public function index(StockingsRepository $stockingsRepo)
    {
        $stockings  = $stockingsRepo->findCurrent();

        return $this->render('lists/index.html.twig', [
            'stockings' => $stockings,
        ]);
    }
}
