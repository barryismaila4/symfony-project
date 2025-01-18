<?php

namespace App\Controller;

use App\Entity\DanceCategory;
use App\Form\DanceCategoryType;
use App\Repository\DanceCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/dance/category')]
final class DanceCategoryController extends AbstractController
{
    #[Route(name: 'app_dance_category_index', methods: ['GET'])]
    public function index(DanceCategoryRepository $danceCategoryRepository): Response
    {
        return $this->render('dance_category/index.html.twig', [
            'dance_categories' => $danceCategoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_dance_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $danceCategory = new DanceCategory();
        $form = $this->createForm(DanceCategoryType::class, $danceCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($danceCategory);
            $entityManager->flush();

            return $this->redirectToRoute('app_dance_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dance_category/new.html.twig', [
            'dance_category' => $danceCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dance_category_show', methods: ['GET'])]
    public function show(DanceCategory $danceCategory): Response
    {
        return $this->render('dance_category/show.html.twig', [
            'dance_category' => $danceCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_dance_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DanceCategory $danceCategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DanceCategoryType::class, $danceCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_dance_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dance_category/edit.html.twig', [
            'dance_category' => $danceCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dance_category_delete', methods: ['POST'])]
    public function delete(Request $request, DanceCategory $danceCategory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$danceCategory->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($danceCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_dance_category_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/names', name: 'app_dance_category_names', methods: ['GET'])]
    public function getCategoryNames(DanceCategoryRepository $danceCategoryRepository): Response
    {
        // Récupérer les catégories de danse
        $danceCategories = $danceCategoryRepository->findAll();
        
        // Extraire uniquement les noms des catégories
        $categoryNames = array_map(function ($category) {
            return $category->getName();
        }, $danceCategories);

        // Retourner une réponse avec les noms
        return $this->json($categoryNames);
    }

}
