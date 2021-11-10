<?php

namespace App\Controller;

use App\Entity\Medecin;
use App\Form\MedecinType;
use http\Client\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;



class MainController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function home(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }



    /**
     * @Route("/profil", name="profil")
     */
    public function profil(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('main/profil.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }


}
