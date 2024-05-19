<?php

namespace App\Controller\Ajax;

use App\Entity\Animals;
use App\Entity\Users;
use App\Repository\AnimalsRepository;
use App\Repository\CategoryAnimalsRepository;
use App\Repository\UsersRepository;
use App\Services\Mercure\AlertService;
use App\Services\Twig\CategoriesAnimals;
use App\Services\Twig\FindImages;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class AnimalsController extends AbstractController
{
    #[Route('/ajax/animals/categories', name: 'app_ajax_getCategoriesAnimals', methods: ['GET'], condition: "request.headers.get('X-Requested-With') === '%app.requested_ajax%'")]
    public function getCategoriesAnimals(CategoryAnimalsRepository $categoryAnimalsRepository): JsonResponse
    {

        $categories = $categoryAnimalsRepository->findAll();

        if (!isset($categories)) {
            return $this->json("Catégories introuvables", 401);
        }

        return $this->json($categories, 200, context: ['groups'=>'main']);
    }

    #[Route('/ajax/animal', name: 'app_ajax_addAnimal', methods: ['POST'], condition: "request.headers.get('X-Requested-With') === '%app.requested_ajax%'")]
    public function addAnimal(#[CurrentUser] ?Users $user, Request $request, EntityManagerInterface $em, AlertService $alertService, CategoryAnimalsRepository $categoryAnimalsRepository, AnimalsRepository $animalsRepository): JsonResponse
    {
        if (!isset($user)) {
            return $this->json("Non authentifiée", 401);
        }

        $data = json_decode($request->getContent(), true);
        
        if ($data["birthdate"] == null) {
            return $this->json("Date de naissance non récupérée", 401);
        }

        if ($data["category"] == null ||  !is_int($data["category"])) {
            return $this->json("Catégorie de l'animal non récupérée ou erronée", 401);
        }

        if ($data["name"] == null || $data["name"] == "") {
            return $this->json("Nom de l'animal non récupéré ou erroné", 401);
        }

        if (isset($data["animalId"])) {
            if ($animalsRepository->findOneBy(["id" => $data["animalId"], "fk_user" => $user]) == null) {
                return $this->json("L'animal n'appartient pas à l'utilisateur", 401);
            }
        }
        
        try {
            $birthdate = str_replace('/', '-', $data["birthdate"]);
            $animal = isset($data["animalId"]) ? $animalsRepository->findOneBy(["id" => $data["animalId"], "fk_user" => $user]) : new Animals();
            $category = $categoryAnimalsRepository->findOneBy(["id" => $data["category"]]);

            $animal->setBirthdate(new DateTime($birthdate))->setName($data["name"])->setFkCategory($category)->setDescription($data["description"] ?? null)->setRace($data["race"] ?? null)->setWeight($data["weight"] ?? null)->setFkUser($user);

            $em->persist($animal);
            $em->flush();
            $alertService->generate("success", "Félicitation", "Votre animal a bien été sauvegardé");
        } catch (\Throwable $th) {
            $alertService->generate("fail", "Erreur de sauvegarde", "Une erreur s'est produite, votre animal n'a pas été sauvegardé. Veuillez réessayer");
            return $this->json("Erreur lors de la sauvegarde des données : $th", 401);
        }

        return $this->json($animal->getId(), 200);
    }
    
    #[Route('/ajax/animal/user/{id}', name: 'app_ajax_getAnimalsByUser', methods: ['GET'], condition: "request.headers.get('X-Requested-With') === '%app.requested_ajax%'")]
    public function getAnimalsByUser(AnimalsRepository $animalsRepository, FindImages $findImages, $id, UsersRepository $usersRepository): JsonResponse
    {
        $user = $usersRepository->findOneBy(["id" => $id]);

        if (!isset($user)) {
            return $this->json("Utilisateur introuvable", 401);
        }

        $animals = $animalsRepository->findBy(["fk_user" => $user]);

        if (!isset($animals)) {
            return $this->json("Animaux introuvables", 401);
        }

        foreach ($animals as $animal) {
            $images = $findImages->findAnimalImages($animal->getId());
            $animal->setImages($images);
        }

        return $this->json($animals, 200, context: ['groups'=>'main']);
    }

    #[Route('/ajax/animal/{id}', name: 'app_ajax_getAnimal', methods: ['GET'], condition: "request.headers.get('X-Requested-With') === '%app.requested_ajax%'")]
    public function getAnimal(#[CurrentUser] ?Users $user, AnimalsRepository $animalsRepository, FindImages $findImages, $id): JsonResponse
    {
        if (!isset($user)) {
            return $this->json("Non authentifiée", 401);
        }
        
        if (!isset($id)) {
            return $this->json("Identifiant de l'animal indéfini", 401);
        }

        $animal = $animalsRepository->findOneBy(["id" => $id, "fk_user" => $user]);

        if (!isset($animal)) {
            return $this->json("Animal introuvable", 401);
        }

        $images = $findImages->findAnimalImages($animal->getId());
        $animal->setImages($images);

        return $this->json($animal, 200, context: ['groups'=>'main']);
    }

}
