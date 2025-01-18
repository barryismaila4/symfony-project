<?php
// src/Controller/BackTemplateController.php// src/Controller/BackTemplateController.php
// src/Controller/BackTemplateController.php
namespace App\Controller;

use App\Repository\DanceCategoryRepository;
use App\Repository\DanceSchoolRepository;
use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BackTemplateController extends AbstractController
{
    #[Route('/back/template', name: 'app_back_template')]
    public function index(): Response
    {
        return $this->render('back_template/backtemplate.html.twig');
    }

    #[Route('/back/template/categories', name: 'app_back_template_categories')]
    public function categories(DanceCategoryRepository $danceCategoryRepository): Response
    {
        $danceCategories = $danceCategoryRepository->findAll();
        return $this->render('dance_category/index.html.twig', [
            'dance_categories' => $danceCategories,
            'current_section' => 'categories', // Indique la section actuelle
        ]);
    }

    #[Route('/back/template/schools', name: 'app_back_template_schools')]
    public function schools(DanceSchoolRepository $danceSchoolRepository): Response
    {
        $danceSchools = $danceSchoolRepository->findAll();
        return $this->render('dance_school/index.html.twig', [
            'dance_schools' => $danceSchools,
            'current_section' => 'schools', // Indique la section actuelle
        ]);
    }

    #[Route('/back/template/courses', name: 'app_back_template_courses')]
    public function courses(CourseRepository $courseRepository): Response
    {
        $courses = $courseRepository->findAll();
        return $this->render('course/index.html.twig', [
            'courses' => $courses,
            'current_section' => 'courses', // Indique la section actuelle
        ]);
    }
}