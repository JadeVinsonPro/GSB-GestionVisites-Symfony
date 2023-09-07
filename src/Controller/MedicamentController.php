<?php

namespace App\Controller;

use App\Entity\Medicament;
use App\Form\MedicamentType;
use App\Repository\MedicamentRepository;
use ContainerTp2yeGu\PaginatorInterface_82dac15;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/medicament')]
class MedicamentController extends AbstractController
{
    #[Route('/', name: 'medicament_index', methods: ['GET'])]
    public function medoc(MedicamentRepository $medicamentRepository,Request $request, PaginatorInterface $paginator): Response
    {
       /*$data = $medicamentRepository->findAll();
       $medicaments = $paginator->paginate(
           $data,
           $request->query->getInt('page', 1),
           5
       );*/
        return $this->render('medicament/index.html.twig', [
            'medicaments' => $medicamentRepository->findAll(),
        ]);
    }

    #[Route('/', name: 'medicament_index', methods: ['GET'])]
    public function findMedicamentByNom(MedicamentRepository $medicamentRepository): Response
    {
        $request = Request::createFromGlobals();
        $query =  $request->query->get('nomCommercial');
        if($query != '' && $query != Null){
            $medicaments = $medicamentRepository->findMedicamentByNom($query);
        } else {
            $medicaments = $medicamentRepository->findAll();
        }
        //$loggedUser =  $this->getUser();
        return $this->render('medicament/index.html.twig', [
            'medicaments' => $medicaments,
            //'medecins' =>$medecinRepository->findBy(['visiteur'=> $loggedUser]),
        ]);

    }

    #[Route('/new', name: 'medicament_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $medicament = new Medicament();
        $form = $this->createForm(MedicamentType::class, $medicament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($medicament);
            $entityManager->flush();

            return $this->redirectToRoute('medicament_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('medicament/new.html.twig', [
            'medicament' => $medicament,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'medicament_show', methods: ['GET'])]
    public function show(Medicament $medicament): Response
    {
        return $this->render('medicament/show.html.twig', [
            'medicament' => $medicament,
        ]);
    }

    #[Route('/{id}/edit', name: 'medicament_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Medicament $medicament): Response
    {
        $form = $this->createForm(MedicamentType::class, $medicament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('medicament_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('medicament/edit.html.twig', [
            'medicament' => $medicament,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'medicament_delete', methods: ['POST'])]
    public function delete(Request $request, Medicament $medicament): Response
    {
        if ($this->isCsrfTokenValid('delete'.$medicament->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($medicament);
            $entityManager->flush();
        }

        return $this->redirectToRoute('medicament_index', [], Response::HTTP_SEE_OTHER);
    }
}
