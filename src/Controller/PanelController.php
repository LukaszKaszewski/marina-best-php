<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PanelController extends AbstractController
{
    #[Route('/panel', name: 'app_panel')]
    #[IsGranted('ROLE_USER')]
    public function index(): Response
    {
        $user = $this->getUser();
        return $this->render('panel/index.html.twig', [
            'controller_name' => 'PanelController',
            'user' => $user,
        ]);
    }
}
