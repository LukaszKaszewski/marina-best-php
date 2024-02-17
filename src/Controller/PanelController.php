<?php

namespace App\Controller;

use App\Repository\PlaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Entity\User;
use App\Entity\Boat;
use App\Entity\Place;
use App\Repository\UserRepository;

class PanelController extends AbstractController
{
    #[Route('/panel', name: 'app_panel')]
    #[IsGranted('ROLE_USER')]
    public function index(PlaceRepository $placeRepository): Response
    {
        $user = $this->getUser();
        $reservation = $placeRepository->reservation();
        return $this->render('panel/index.html.twig', [
            'controller_name' => 'PanelController',
            'user' => $user,
            'reservation' => $reservation
        ]);
    }


}
