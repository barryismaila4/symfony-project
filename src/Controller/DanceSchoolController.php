<?php

namespace App\Controller;

use App\Entity\DanceSchool;
use App\Form\DanceSchoolType;
use App\Repository\DanceSchoolRepository;
use App\Repository\DanceCategoryRepository;  // Ajout du DanceCategoryRepository
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/dance/school')]
final class DanceSchoolController extends AbstractController
{
    #[Route(name: 'app_dance_school_index', methods: ['GET'])]
    public function index(DanceSchoolRepository $danceSchoolRepository): Response
    {
        return $this->render('dance_school/index.html.twig', [
            'dance_schools' => $danceSchoolRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_dance_school_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, DanceCategoryRepository $danceCategoryRepository): Response
    {
        $danceSchool = new DanceSchool();
        $form = $this->createForm(DanceSchoolType::class, $danceSchool);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Ici, vous n'avez plus besoin de chercher une DanceCategory par son nom
            $danceCategory = $form->get('danceCategory')->getData();  // Récupérer l'objet DanceCategory sélectionné dans le formulaire
    
            // Associer la DanceCategory à la DanceSchool
            $danceSchool->setDanceCategory($danceCategory);
    
            // Persist et flush de la DanceSchool
            $entityManager->persist($danceSchool);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_dance_school_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('dance_school/new.html.twig', [
            'dance_school' => $danceSchool,
            'form' => $form,
        ]);
    }
    
    #[Route('/{id}', name: 'app_dance_school_show', methods: ['GET'])]
    public function show(DanceSchool $danceSchool): Response
    {
        return $this->render('dance_school/show.html.twig', [
            'dance_school' => $danceSchool,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_dance_school_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DanceSchool $danceSchool, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DanceSchoolType::class, $danceSchool);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_dance_school_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dance_school/edit.html.twig', [
            'dance_school' => $danceSchool,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_dance_school_delete', methods: ['POST'])]
    public function delete(Request $request, DanceSchool $danceSchool, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$danceSchool->getId(), $request->get('_token'))) {
            $entityManager->remove($danceSchool);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_dance_school_index', [], Response::HTTP_SEE_OTHER);
    }
}
