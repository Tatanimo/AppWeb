<?php

namespace App\Controller\Ajax;

use App\Repository\CategoryAnimalsRepository;
use App\Repository\ProfessionalsRepository;
use App\Services\Mercure\AlertService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/ajax/categoriesanimals/{id}', name: 'app_getCategoriesAnimalsNotInProfessional', methods: ['GET'], condition: "request.headers.get('X-Requested-With') === '%app.requested_ajax%'")]
    public function getAllCategoriesAnimalsNotInProfessional(CategoryAnimalsRepository $categoryAnimalsRepository, ProfessionalsRepository $professionalsRepository, $id): JsonResponse
    {
        $categories = $categoryAnimalsRepository->findAll();

        if (!isset($categories)) {
            return $this->json("Categories non trouvés", 400);
        }

        $professional = $professionalsRepository->findOneBy(["id" => $id]);

        if (!isset($professional)) {
            return $this->json("Professionnel non trouvé", 400);
        }

        $categoriesInProfessional = $professional->getAllowedCategories();

        $categoriesNotInProfessional = array_values(array_filter($categories, function($categorie) use($categoriesInProfessional){
            return !in_array($categorie, $categoriesInProfessional->toArray());
        }));

        return $this->json($categoriesNotInProfessional, 200, context:['groups' => 'main']);
    }

    #[Route('/ajax/categoriesanimals/delete/{idCat}/{idPro}', name: 'app_deleteCategoryAnimalProfessional', methods: ['POST'], condition: "request.headers.get('X-Requested-With') === '%app.requested_ajax%'")]
    public function deleteCategoryAnimalProfessional(CategoryAnimalsRepository $categoryAnimalsRepository, ProfessionalsRepository $professionalsRepository, AlertService $alert, $idCat, $idPro, EntityManagerInterface $em): JsonResponse
    {
        $professional = $professionalsRepository->findOneBy(["id" => $idPro]);
        
        if (!isset($professional)) {
            return $this->json("Professionnel non trouvé", 400);
        }

        $category = $categoryAnimalsRepository->findOneBy(["id" => $idCat]);

        if (!isset($category)) {
            return $this->json("Catégorie non trouvé", 400);
        }

        $professional->removeAllowedCategory($category);

        try {
            $em->persist($professional);
            $em->flush();
            $alert->generate("success", "Suppression de la catégorie animal", "La catégorie animal de votre compte professionnel a bien été supprimé.");
            return $this->json($professional, 200, context:["groups" => "main"]);
        } catch (\Throwable $th) {
            $alert->generate("fail", "Erreur de suppression", "Une erreur s'est produite, la catégorie animal de votre compte professionnel n'a pas été supprimé. Veuillez réessayer.");
            return $this->json("Delete failed", 400);
        }
    }

    #[Route('/ajax/categoriesanimals/add/{idPro}', name: 'app_addCategoriesAnimalsProfessional', methods: ['POST'], condition: "request.headers.get('X-Requested-With') === '%app.requested_ajax%'")]
    public function addCategoriesAnimalsProfessional(Request $request, ProfessionalsRepository $professionalsRepository, CategoryAnimalsRepository $categoryAnimalsRepository, AlertService $alert, $idPro, EntityManagerInterface $em): JsonResponse
    {
        $professional = $professionalsRepository->findOneBy(["id" => $idPro]);
        
        if (!isset($professional)) {
            return $this->json("Professionnel non trouvé", 400);
        }

        $data = json_decode($request->getContent(), true);
        $categories = $data['categories'] ?? null;

        if (!isset($categories)) {
            return $this->json("Catégories non trouvées", 400);
        }

        foreach ($categories as $category) {
            $categoryAnimal = $categoryAnimalsRepository->findOneBy(["id" => $category]);
            $professional->addAllowedCategory($categoryAnimal);
        }

        try {
            $em->persist($professional);
            $em->flush();
            if(count($categories) > 1){
                $alert->generate("success", "Ajout de plusieurs catégories", "Les catégories animaux de votre compte professionnel ont bien étaient ajoutés.");
            } else {
                $alert->generate("success", "Ajout d'une catégorie", "La catégorie animal de votre compte professionnel a bien était ajouté.");
            }
            return $this->json($professional, 200, context:["groups" => "main"]);
        } catch (\Throwable $th) {
            if(count($categories) > 1){
                $alert->generate("fail", "Erreur d'ajout", "Une erreur s'est produite, les catégories animaux de votre compte professionnel n'ont pas étaient ajoutés. Veuillez réessayer.");
            } else {
                $alert->generate("fail", "Erreur d'ajout", "Une erreur s'est produite, la catégorie animal de votre compte professionnel n'a pas été ajouté. Veuillez réessayer.");
            }
            return $this->json("Delete failed", 400);
        }
    }
}
