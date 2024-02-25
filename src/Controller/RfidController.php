<?php

namespace App\Controller;

use App\Entity\Rfid;
use App\Form\RfidType;
use App\Repository\RfidRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rfid')]
class RfidController extends AbstractController
{
    #[Route('/', name: 'app_rfid_index', methods: ['GET'])]
    public function index(RfidRepository $rfidRepository): Response
    {
        return $this->render('rfid/index.html.twig', [
            'rfids' => $rfidRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_rfid_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $rfid = new Rfid();
        $form = $this->createForm(RfidType::class, $rfid);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rfid);
            $entityManager->flush();

            return $this->redirectToRoute('app_rfid_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('rfid/new.html.twig', [
            'rfid' => $rfid,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rfid_show', methods: ['GET'])]
    public function show(Rfid $rfid): Response
    {
        return $this->render('rfid/show.html.twig', [
            'rfid' => $rfid,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_rfid_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Rfid $rfid, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RfidType::class, $rfid);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_rfid_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('rfid/edit.html.twig', [
            'rfid' => $rfid,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rfid_delete', methods: ['POST'])]
    public function delete(Request $request, Rfid $rfid, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rfid->getId(), $request->request->get('_token'))) {
            $entityManager->remove($rfid);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_rfid_index', [], Response::HTTP_SEE_OTHER);
    }
}
