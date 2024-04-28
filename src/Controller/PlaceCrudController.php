<?php

namespace App\Controller;

use App\Entity\Place;
use App\Form\Place1Type;
use App\Repository\PlaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use function PHPUnit\Framework\isEmpty;
use function Symfony\Component\Clock\now;

#[Route('/userpanel')]
#[IsGranted('ROLE_USER')]
class PlaceCrudController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/', name: 'app_place_crud_index', methods: ['GET'])]
    public function index(PlaceRepository $placeRepository, Security $security): Response
    {
        $user = $this->getUser();

        $reservation = $placeRepository->reservation();


        return $this->render('place_crud/index.html.twig', [
            'places' => $placeRepository->findAll(),
            'user' => $user,
            // show reservation
            'reservation' => $reservation
        ]);
    }

    #[Route('/new', name: 'app_place_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Security $security, PlaceRepository $placeRepository): Response
    {

        $isAdmin = $this->security->isGranted('ROLE_ADMIN');

        // get logged user
        $loggedInUser = $security->getUser();
        $place = new Place();
        $form = $this->createForm(Place1Type::class, $place);

        // set default value as logged user
        $form->get('user_id')->setData($loggedInUser);

        $form->handleRequest($request);

        $newPlace = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $startDate = $data->getStartDate();
            $endDate = $data->getEndDate();
            $placeNumber = $data->getNumber();
            $currentDate = now(); //today

            $newPlace = $placeRepository->checkNewPlaces($startDate, $endDate, $placeNumber);

            if($isAdmin) {
                if($newPlace) {
                    $this->addFlash('error',  'We wskazanym terminie, miejsce nr (' . $placeNumber . ') jest już zarezerwowane');
                } else {
                    $entityManager->persist($place);
                    $entityManager->flush();
                    $this->addFlash('error',  'Zarezerwowano miejsce nr (' . $placeNumber . ')');
                }
            } else {
                if($newPlace) {
                    $this->addFlash('error',  'We wskazanym terminie, miejsce nr (' . $placeNumber . ') jest już zarezerwowane');
                } else {
                    if ($startDate > $endDate) {
                        $this->addFlash('error', 'Data początkowa nie może być większa od daty końcowej');
                        // var_dump('Data początkowa nie może być większa od daty końcowej');
                    } elseif ($startDate < $currentDate || $endDate < $currentDate) {
                        $this->addFlash('error', 'Możesz rezerwować tylko terminy w przyszłości');
                        // var_dump('Nie można wybrać daty wcześniejszej niż dzisiejsza');
                    } else {
                        $entityManager->persist($place);
                        $entityManager->flush();
                        $this->addFlash('error',  'Zarezerwowano miejsce nr (' . $placeNumber . ')');
                    }



                }
            }


            // after flush() back to index
            return $this->redirectToRoute('app_place_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('place_crud/new.html.twig', [
            'place' => $place,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_place_crud_show', methods: ['GET'])]
    public function show(Place $place): Response
    {
        return $this->render('place_crud/show.html.twig', [
            'place' => $place,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_place_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Place $place, EntityManagerInterface $entityManager, Security $security): Response
    {
        // get logged user
        $loggedInUser = $security->getUser();

        $form = $this->createForm(Place1Type::class, $place);
        // set default value as logged user
        $form->get('user_id')->setData($loggedInUser);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            // after flush() back to index
            return $this->redirectToRoute('app_place_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('place_crud/edit.html.twig', [
            'place' => $place,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_place_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Place $place, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$place->getId(), $request->request->get('_token'))) {
            $entityManager->remove($place);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_place_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
