<?php

namespace App\Controller;

use App\Entity\Wintering;
use App\Form\WinteringType;
use App\Repository\WinteringRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use function Symfony\Component\Clock\now;

#[Route('/wintering')]
#[isGranted('ROLE_USER')]
class WinteringController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/', name: 'app_wintering_index', methods: ['GET'])]
    public function index(WinteringRepository $winteringRepository): Response
    {
        $user = $this->getUser();
        return $this->render('wintering/index.html.twig', [
            'winterings' => $winteringRepository->findAll(),
            'user' => $user,
        ]);
    }

    #[Route('/new', name: 'app_wintering_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $isAdmin = $this->security->isGranted('ROLE_ADMIN');

        // get logged usre
        $loggedInUser = $security->getUser();
        $wintering = new Wintering();
        $form = $this->createForm(WinteringType::class, $wintering);

        // set default value as logged user
        $form->get('user_id')->setData($loggedInUser);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $startDate = $data->getStartDate();
            $endDate = $data->getEndDate();
            $currentDate = now(); //today

            // admin can enter data in the past
            if($isAdmin) {
                $entityManager->persist($wintering);
                $entityManager->flush();
            } else {
                if($startDate <= $currentDate or $endDate <= $currentDate) {
                    $this->addFlash('error', 'Błąd: data początkowa oraz końcowa nie może być w przeszłości');
                } elseif($startDate >= $endDate) {
                    $this->addFlash('error', 'Błąd: data końcowa nie może być szybciej niż data początkowa');
                } else {
                    $entityManager->persist($wintering);
                    $entityManager->flush();
                }
            }

            return $this->redirectToRoute('app_wintering_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('wintering/new.html.twig', [
            'wintering' => $wintering,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_wintering_show', methods: ['GET'])]
    public function show(Wintering $wintering): Response
    {
        return $this->render('wintering/show.html.twig', [
            'wintering' => $wintering,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_wintering_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Wintering $wintering, EntityManagerInterface $entityManager): Response
    {
        $isAdmin = $this->security->isGranted('ROLE_ADMIN');

        $form = $this->createForm(WinteringType::class, $wintering);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $startDate = $data->getStartDate();
            $endDate = $data->getEndDate();
            $currentDate = now(); //today

            // admin can enter data in the past
            if($isAdmin) {
                $entityManager->persist($wintering);
                $entityManager->flush();

            } else {
                if($startDate <= $currentDate or $endDate <= $currentDate) {
                    $this->addFlash('error', 'Błąd: data początkowa oraz końcowa nie może być w przeszłości');
                } elseif($startDate >= $endDate) {
                    $this->addFlash('error', 'Błąd: data końcowa nie może być szybciej niż data początkowa');
                } else {
                    $entityManager->flush();
                }
            }

            return $this->redirectToRoute('app_wintering_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('wintering/edit.html.twig', [
            'wintering' => $wintering,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_wintering_delete', methods: ['POST'])]
    public function delete(Request $request, Wintering $wintering, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$wintering->getId(), $request->request->get('_token'))) {
            $entityManager->remove($wintering);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_wintering_index', [], Response::HTTP_SEE_OTHER);
    }
}
