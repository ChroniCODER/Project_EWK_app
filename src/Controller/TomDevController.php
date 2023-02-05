<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TomDevController extends AbstractController
{
    #[Route('/tomDev', name: 'app_tom_dev')]
    public function index(): Response
    {
        return $this->render('tom_dev/index.html.twig', [
            'controller_name' => 'TomDevController',
        ]);
    }
}
