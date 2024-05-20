<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmailfailController extends AbstractController
{
    #[Route('/emailfail', name: 'app_emailfail')]
    public function index(): Response
    {
        return $this->render('emailfail/index.html.twig', [
            'controller_name' => 'EmailfailController',
        ]);
    }
}
