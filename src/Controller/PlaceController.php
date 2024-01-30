<?php

namespace App\Controller;

use App\Entity\Place;
use App\Repository\PlaceRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; // do requets
use Symfony\Component\HttpFoundation\Response; // do request
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PlaceType;
use function Symfony\Component\Clock\now;

class PlaceController extends AbstractController
{
    #[Route('/place', name: 'app_place')]
    public function index(Request $request, PlaceRepository $placeRepository): Response
    {
        $form = $this->createForm(PlaceType::class);
        $form->handleRequest($request);

        $places = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $startDate = $data->getStartDate();
            $endDate = $data->getEndDate();

            // szuka wolnych miejsc w repo i sprawdze bledy w formularzu
            if ($startDate > $endDate) {
                $this->addFlash('error', 'Data początkowa nie może być większa od daty końcowej');
//              var_dump('Data początkowa nie może być większa od daty końcowej');
            } elseif ($startDate == null || $endDate == null) {
                $this->addFlash('error', 'Data początkowa i końcowa nie mogą być puste');
            } else {
                $places = $placeRepository->findByIsTaken($startDate, $endDate);
            }

        }

        return $this->render('place/index.html.twig', [
            'controller_name' => 'PlaceController',
            'places' => $places,
            'form' => $form->createView(),
        ]);
    }
}