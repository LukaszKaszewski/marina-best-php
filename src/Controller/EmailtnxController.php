<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmailtnxController extends AbstractController
{
    #[Route('/emailtnx', name: 'app_emailtnx')]
    public function index(): Response
    {
        return $this->render('emailtnx/index.html.twig', [
            'controller_name' => 'EmailtnxController',
        ]);
    }
}
