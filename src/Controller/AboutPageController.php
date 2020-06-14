<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AboutPageController extends AbstractController
{
    /**
     * @Route("/about", name="about_page")
     */
    public function index()
    {
        return $this->render('about_page/index.html.twig', [
            'controller_name' => 'AboutPageController',
        ]);
    }
}
