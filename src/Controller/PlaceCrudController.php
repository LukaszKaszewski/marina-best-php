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

#[Route('/userpanel')]
class PlaceCrudController extends AbstractController
{
    #[Route('/', name: 'app_place_crud_index', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function index(PlaceRepository $placeRepository, Security $security): Response
    {
        $user = $this->getUser();
//        $loggedUser = $security->getUser();

        $reservation = $placeRepository->reservation();
        return $this->render('place_crud/index.html.twig', [
            'places' => $placeRepository->findAll(),
            'user' => $user,
            //            'loggedUser' => $loggedUser,
            'reservation' => $reservation
        ]);
    }

    #[Route('/new', name: 'app_place_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        // Pobierz zalogowanego użytkownika
        $loggedInUser = $security->getUser();
        $place = new Place();
        $form = $this->createForm(Place1Type::class, $place);

        // Ustaw domyślną wartość user_id jako id zalogowanego użytkownika
        $form->get('user_id')->setData($loggedInUser);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($place);
            $entityManager->flush();

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
        // Pobierz zalogowanego użytkownika
        $loggedInUser = $security->getUser();

        $form = $this->createForm(Place1Type::class, $place);
        // Ustaw domyślną wartość user_id jako id zalogowanego użytkownika
        $form->get('user_id')->setData($loggedInUser);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

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
