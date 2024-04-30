<?php

namespace App\Controller\Ajax;

use App\Repository\CategoryAnimalsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class CategoriesAnimalsController extends AbstractController
{
    #[Route('/ajax/categoriesanimals', name: 'app_getCategoriesAnimals', methods: ['GET'], condition: "request.headers.get('X-Requested-With') === '%app.requested_ajax%'")]
    public function getAllCategoriesAnimals(CategoryAnimalsRepository $categoryAnimalsRepository): JsonResponse
    {
        $categories = $categoryAnimalsRepository->findAll();

        if (!isset($categories)) {
            return $this->json("Categories non trouvés", 400);
        }

        return $this->json($categories, 200, context:['groups' => 'main']);
    }
}
