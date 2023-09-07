<?php

namespace App\Controller;

use App\Entity\Rapport;
use App\Entity\Visiteur;
use App\Form\RapportType;
use App\Repository\MedecinRepository;
use App\Repository\OffrirRepository;
use App\Repository\RapportRepository;
use App\Repository\VisiteurRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rapport')]
class RapportController extends AbstractController
{
    #[Route('/', name: 'rapport_index', methods: ['GET'])]
    public function index(RapportRepository $rapportRepository, OffrirRepository $offrirRepository): Response
    {
        $loggedUser = $this->getUser();
        return $this->render('rapport/index.html.twig', [
            'rapports' => $rapportRepository->findBy(['visiteur' => $loggedUser]),
        ]);

    }


    #[Route('/', name: 'rapport_index', methods: ['GET'])]
    public function rechercheParDate(RapportRepository $rapportRepository): Response
    {
        $request = Request::createFromGlobals();
        $query = $request->query->get('date');
        $loggedUser = $this->getUser();


        if ($query != '' && $query != Null) {
            $rapports = $rapportRepository->rechercheParDate(date_create($query));
        } else {
            $rapports = $rapportRepository->findBy(['visiteur' => $loggedUser]);
        }
        return $this->render('rapport/index.html.twig', [
            'rapports' => $rapports
        ]);
    }

    #[Route('/new', name: 'rapport_new', methods: ['GET','POST'])]
    public function new(Request $request, VisiteurRepository  $visiteurRepository, LoggerInterface $logger): Response
    {
        $this->denyAccessUnlessGranted('ROLE_VISITEUR');
        $rapport = new Rapport();
        $form = $this->createForm(RapportType::class, $rapport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* $visiteur = $this->container
                 ->get('security.context')->getToken()->getUser();*/

            $loggedUser = $this->getUser();

            $visiteur = $visiteurRepository->findOneBy(['login' => $loggedUser->getUserIdentifier()]);//recupere l'id du visiteur
            $rapport->setVisiteur($visiteur); // inscrit automatique l'id visiteur

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rapport);//informe Doctrine que l’on veut ajouter cet objet dans la base de donneé
            $entityManager->flush(); //permet d’exécuter la requête et d’envoyer tout ce qui a été persiste avant à la base de données.

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
        $this->denyAccessUnlessGranted('ROLE_VISITEUR');
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
        $this->denyAccessUnlessGranted('ROLE_VISITEUR');
        if ($this->isCsrfTokenValid('delete'.$rapport->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rapport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rapport_index', [], Response::HTTP_SEE_OTHER);
    }
}
