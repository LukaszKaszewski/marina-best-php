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
use Symfony\Component\Security\Core\Security;

class PlaceController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/place', name: 'app_place')]
    public function index(Request $request, PlaceRepository $placeRepository): Response
    {
        $isAdmin = $this->security->isGranted('ROLE_ADMIN');

        $form = $this->createForm(PlaceType::class);
        $form->handleRequest($request);

        $places = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $startDate = $data->getStartDate();
            $endDate = $data->getEndDate();
            $currentDate = now(); //today
//            $yesterday = (new \DateTime())->modify('-1 day'); // yesterday date
            // szuka wolnych miejsc w repo i sprawdze bledy w formularzu
            if($isAdmin) {
                // admin can check history
                if ($startDate > $endDate) {
                    $this->addFlash('error', 'Data początkowa nie może być większa od daty końcowej');
                    // var_dump('Data początkowa nie może być większa od daty końcowej');
                } elseif ($startDate == null || $endDate == null) {
                    $this->addFlash('error', 'Data początkowa i końcowa nie mogą być puste');
                    // var_dump('Data początkowa i końcowa nie mogą być puste');
                } else {
                    $places = $placeRepository->findByIsTaken($startDate, $endDate);
                }
            } else {
                // user check only future
                if ($startDate > $endDate) {
                    $this->addFlash('error', 'Data początkowa nie może być większa od daty końcowej');
                    // var_dump('Data początkowa nie może być większa od daty końcowej');
                } elseif ($startDate == null || $endDate == null) {
                    $this->addFlash('error', 'Data początkowa i końcowa nie mogą być puste');
                    // var_dump('Data początkowa i końcowa nie mogą być puste');
                } elseif ($startDate < $currentDate || $endDate < $currentDate) {
                    $this->addFlash('error', 'Możesz sprawdzić daty tylko w przyszłości');
                    // var_dump('Nie można wybrać daty wcześniejszej niż dzisiejsza');
                } else {
                    $places = $placeRepository->findByIsTaken($startDate, $endDate);
                }
            }


        }

        return $this->render('place/index.html.twig', [
            'controller_name' => 'PlaceController',
            'places' => $places,
            'form' => $form->createView(),
        ]);
    }
}