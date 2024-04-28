<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use function Symfony\Component\Clock\now;

#[Route('/service')]
#[isGranted('ROLE_USER')]
class ServiceController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/', name: 'app_service_index', methods: ['GET'])]
    public function index(ServiceRepository $serviceRepository): Response
    {
        $user = $this->getUser();
        return $this->render('service/index.html.twig', [
            'services' => $serviceRepository->findAll(),
            'user' => $user,
        ]);
    }

    #[Route('/new', name: 'app_service_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $isAdmin = $this->security->isGranted('ROLE_ADMIN');

        // get logged user
        $loggedInUser = $security->getUser();
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);

        // set default value as logged user
        $form->get('user_id')->setData($loggedInUser);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $startDate = $data->getDate();
            $currentDate = now(); //today

            // admin can enter data in the past
            if($isAdmin) {
                $entityManager->persist($service);
                $entityManager->flush();
            } else {
                if($startDate <= $currentDate) {
                    $this->addFlash('error', 'Błąd: data początkowa nie może być w przeszłości');
                } else {
                    $entityManager->persist($service);
                    $entityManager->flush();
                }
            }

            return $this->redirectToRoute('app_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('service/new.html.twig', [
            'service' => $service,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_service_show', methods: ['GET'])]
    public function show(Service $service): Response
    {
        return $this->render('service/show.html.twig', [
            'service' => $service,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_service_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Service $service, EntityManagerInterface $entityManager): Response
    {
        $isAdmin = $this->security->isGranted('ROLE_ADMIN');

        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $startDate = $data->getDate();
            $currentDate = now(); //today

            if($isAdmin) {
                $entityManager->persist($service);
                $entityManager->flush();
            } else {
                if($startDate <= $currentDate) {
                    $this->addFlash('error', 'Błąd: data początkowa nie może być w przeszłości');
                } else {
                    $entityManager->persist($service);
                    $entityManager->flush();
                }
            }
            return $this->redirectToRoute('app_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('service/edit.html.twig', [
            'service' => $service,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_service_delete', methods: ['POST'])]
    public function delete(Request $request, Service $service, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$service->getId(), $request->request->get('_token'))) {
            $entityManager->remove($service);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_service_index', [], Response::HTTP_SEE_OTHER);
    }
}
