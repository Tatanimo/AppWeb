<?php

namespace App\Controller\Ajax;

use App\Entity\Animals;
use App\Entity\Users;
use App\Repository\CategoryAnimalsRepository;
use App\Services\Mercure\AlertService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class AnimalsController extends AbstractController
{
    #[Route('/ajax/animal', name: 'app_ajax_addAnimal', methods: ['POST'], condition: "request.headers.get('X-Requested-With') === '%app.requested_ajax%'")]
    public function addAnimal(#[CurrentUser] ?Users $user, Request $request, EntityManagerInterface $em, AlertService $alertService, CategoryAnimalsRepository $categoryAnimalsRepository): JsonResponse
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

        try {
            $animal = new Animals();
            $category = $categoryAnimalsRepository->findOneBy(["id" => $data["category"]]);

            $animal->setBirthdate(new DateTime($data["birthdate"]))->setName($data["name"])->setFkCategory($category)->setDescription($data["description"])->setRace($data["race"])->setWeight($data["weight"])->setFkUser($user);

            $em->persist($animal);
            $em->flush();
            $alertService->generate("success", "Félicitation", "Votre animal a bien été sauvegardé");
        } catch (\Throwable $th) {
            $alertService->generate("fail", "Erreur de sauvegarde", "Une erreur s'est produite, votre animal n'a pas été sauvegardé. Veuillez réessayer");
            return $this->json("Erreur lors de la sauvegarde des données : $th", 401);
        }

        return $this->json("Animal sauvegardé", 200);
    }
}
