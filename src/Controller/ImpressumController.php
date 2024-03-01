<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ImpressumController extends AbstractController
{
    #[Route(path: '/impressum', name: 'impressum')]

    public function index()
    {
        return $this->render('impressum/index.html.twig', [
            'controller_name' => 'ImpressumController',
        ]);
    }
}
