<?php

namespace App\Controller;

use App\Entity\Rapport;
use App\Form\RapportType;
use App\Repository\RapportRepository;
use App\Repository\VisiteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rapport')]
class RapportController extends AbstractController
{
    #[Route('/', name: 'rapport_index', methods: ['GET'])]
    public function index(RapportRepository $rapportRepository): Response
    {
        $loggedUser = $this->getUser();
        return $this->render('rapport/index.html.twig', [
            'rapports' => $rapportRepository->findBy(['visiteur' => $loggedUser]),
        ]);

    }

    #[Route('/new', name: 'rapport_new', methods: ['GET','POST'])]
    public function new(Request $request, VisiteurRepository  $visiteurRepository): Response
    {
        $rapport = new Rapport();
        $form = $this->createForm(RapportType::class, $rapport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            $loggedUser = $this->getUser();
//            $visiteur = $visiteurRepository->findOneBy()['username' => $loggedUser->getUserIdentifier()]
//            $rapport->setVisiteur($visiteur);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rapport);
            $entityManager->flush();

            return $this->redirectToRoute('rapport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rapport/new.html.twig', [
            'rapport' => $rapport,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'rapport_show', methods: ['GET'])]
    public function show(Rapport $rapport): Response
    {
        return $this->render('rapport/show.html.twig', [
            'rapport' => $rapport,
        ]);
    }

    #[Route('/{id}/edit', name: 'rapport_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Rapport $rapport): Response
    {
        $form = $this->createForm(RapportType::class, $rapport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rapport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rapport/edit.html.twig', [
            'rapport' => $rapport,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'rapport_delete', methods: ['POST'])]
    public function delete(Request $request, Rapport $rapport): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rapport->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rapport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rapport_index', [], Response::HTTP_SEE_OTHER);
    }
}
