<?php

namespace App\Controller;

use App\Entity\Rapport;
use App\Repository\RapportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListeRapportsController extends AbstractController
{
    #[Route('/listerapports', name: 'liste_rapports')]
    #[Route('/listerapports', name: 'liste_rapports_index')]
    public function index(RapportRepository $rapportRepository): Response
    {
        $rapports =  ($rapportRepository->findAll());
        return $this->render('liste_rapports/index.html.twig', ['rapports' => $rapports]);
    }

    #[Route('/listerapports/{id}', name: 'liste_rapports_detail')]
    public function detail(Rapport $rapport): Response
    {
        return $this->render('liste_rapports/detail.html.twig', ['rapports' => $rapport]);

    }


}
