<?php

namespace App\Controller;

use App\Entity\Medecin;
use App\Form\MedecinType;
use App\Repository\MedecinRepository;
use App\Repository\RapportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/medecin')]
class MedecinController extends AbstractController
{
    #[Route('/', name: 'medecin_index', methods: ['GET'])]
    public function index(MedecinRepository $medecinRepository,RapportRepository $rapportRepository): Response
    {
        return $this->render('medecin/index.html.twig', [
            'medecins' => $medecinRepository->findAll(),
        ]);
    }



    #[Route('/', name: 'medecin_index', methods: ['GET'])]
    public function findMedecinByNom(MedecinRepository $medecinRepository): Response
    {
        $request = Request::createFromGlobals();
        $query =  $request->query->get('nom');
        if($query != '' && $query != Null){
            $medecins = $medecinRepository->findMedecinByNom($query);
        } else {
            $medecins = $medecinRepository->findAll();
        }
        //$loggedUser =  $this->getUser();
        return $this->render('medecin/index.html.twig', [
            'medecins' => $medecins,
            //'medecins' =>$medecinRepository->findBy(['visiteur'=> $loggedUser]),
        ]);

    }

    #[Route('/new', name: 'medecin_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $medecin = new Medecin();
        $form = $this->createForm(MedecinType::class, $medecin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($medecin);
            $entityManager->flush();

            return $this->redirectToRoute('medecin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('medecin/new.html.twig', [
            'medecin' => $medecin,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'medecin_show', methods: ['GET'])]
    public function show(Medecin $medecin): Response
    {
        return $this->render('medecin/show.html.twig', [
            'medecin' => $medecin,
        ]);
    }

    #[Route('/{id}/edit', name: 'medecin_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Medecin $medecin): Response
    {
        $form = $this->createForm(MedecinType::class, $medecin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('medecin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('medecin/edit.html.twig', [
            'medecin' => $medecin,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'medecin_delete', methods: ['POST'])]
    public function delete(Request $request, Medecin $medecin): Response
    {
        if ($this->isCsrfTokenValid('delete'.$medecin->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($medecin);
            $entityManager->flush();
        }

        return $this->redirectToRoute('medecin_index', [], Response::HTTP_SEE_OTHER);
    }


}
