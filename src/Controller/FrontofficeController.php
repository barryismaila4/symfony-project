<?php

namespace App\Controller;

use App\Repository\DanceCategoryRepository;
use App\Repository\DanceSchoolRepository;
use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class FrontofficeController extends AbstractController
{
    // Page principale : liste des catégories
    #[Route('/frontoffice', name: 'app_frontoffice')]
    public function index(DanceCategoryRepository $danceCategoryRepository): Response
    {
        $danceCategories = $danceCategoryRepository->findAll();

        return $this->render('frontoffice/index.html.twig', [
            'dance_categories' => $danceCategories,
        ]);
    }

    // Page : liste des écoles pour une catégorie
    #[Route('/frontoffice/category/{id}', name: 'app_dance_category_show')]
    public function showCategory(
        DanceCategoryRepository $danceCategoryRepository,
        DanceSchoolRepository $danceSchoolRepository,
        int $id
    ): Response {
        $danceCategory = $danceCategoryRepository->find($id);

        if (!$danceCategory) {
            throw $this->createNotFoundException('Category not found');
        }

        $danceSchools = $danceSchoolRepository->findBy(['danceCategory' => $danceCategory]);

        return $this->render('frontoffice/category_show.html.twig', [
            'category_name' => $danceCategory->getName(),
            'dance_schools' => $danceSchools,
        ]);
    }

    // Page : liste des cours pour une école
    #[Route('/frontoffice/school/{id}', name: 'app_dance_school_courses')]
    public function showCourses(
        DanceSchoolRepository $danceSchoolRepository,
        CourseRepository $courseRepository,
        int $id
    ): Response {
        $danceSchool = $danceSchoolRepository->find($id);

        if (!$danceSchool) {
            throw $this->createNotFoundException('School not found');
        }

        $courses = $courseRepository->findBy(['danceSchool' => $danceSchool]);

        return $this->render('frontoffice/school_courses.html.twig', [
            'school_name' => $danceSchool->getName(),
            'localisation' => $danceSchool->getLocalisation(),
            'openday' => $danceSchool->getOpenday(),
            'closeday' => $danceSchool->getCloseday(),
            'opentime' => $danceSchool->getOpentime(),
            'closetime' => $danceSchool->getClosetime(),
            'courses' => $courses,
        ]);
    }
    

   
}
