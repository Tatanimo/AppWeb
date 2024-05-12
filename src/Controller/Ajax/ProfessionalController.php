<?php 

namespace App\Controller\Ajax;

use App\Entity\Professionals;
use App\Entity\Users;
use App\Repository\CitiesRepository;
use App\Repository\ProfessionalsRepository;
use App\Repository\ServicesTypeRepository;
use App\Services\CalculatingDistance;
use App\Services\Mercure\AlertService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ProfessionalController extends AbstractController
{
    #[Route('/ajax/professional', name: 'app_addProfessional', methods: ['POST'], condition: "request.headers.get('X-Requested-With') === '%app.requested_ajax%'")]
    public function addProfessional(Request $request, ServicesTypeRepository $servicesTypeRepository, CitiesRepository $citiesRepository, AlertService $alert, EntityManagerInterface $em): JsonResponse
    {
        $user = $this->getUser();

        if (!isset($user)) {
            return $this->json("Non authentifiée", 401);
        }

        $data = json_decode($request->getContent(), true);

        $serviceId = $data["service"] ?? null;
        $cityFetch = $data['city'] ?? null;
        $housing = $data['housing'] ?? null;
        $address = $data['address'] ?? null;
        $price = $data['price'] ?? null;

        if (isset($serviceId) && isset($cityFetch) && isset($housing) && isset($address) && isset($price)) {
            $professional = new Professionals();

            $service = $servicesTypeRepository->findOneBy(["id" => $serviceId]);
            $city = $citiesRepository->findOneBy(["id" => $cityFetch["id"]]);

            $professional->setUser($user)->setService($service)->setCity($city)->setLiveIn($housing)->setAddress($address)->setPrice($price);

            $type = $service->getType();

            try {
                $em->persist($professional);
                $em->flush();
                
                $alert->generate("success", "Compte professionnel enregistré", "Votre compte $type a bien été enregistré.");

                return $this->json('success', 200);
            } catch (\Throwable $th) {
                $alert->generate("fail", "Erreur de sauvegarde", "Une erreur s'est produite, votre compte n'a pas été enregistré. Veuillez réessayer.");
                
                return $this->json('Fail to save the user in database. The error is: '.$th, 400);
            }
        } else {
            $alert->generate("fail", "Erreur de sauvegarde", "Une erreur s'est produite, une ou plusieurs données sont manquantes.");
            return $this->json("Fail to fetch data, there's one or multiple missing.", 400);
        }
    }

    #[Route('/ajax/professional', name: 'app_getProfessional', methods: ['GET'], condition: "request.headers.get('X-Requested-With') === '%app.requested_ajax%'")]
    public function getProfessional(#[CurrentUser] Users $user, ProfessionalsRepository $professionalsRepository): JsonResponse 
    {
        if (!isset($user)) {
            return $this->json("Non authentifiée", 401);
        }

        $professional = $professionalsRepository->findOneBy(["user" => $user]);

        if (!isset($professional)) {
            return $this->json(false, 200);
        } else {
            return $this->json($professional, 200, context: ["groups" => "main"]);
        }
    }

    #[Route('/ajax/professional/desc/{id}', name: 'app_setProfessionalDescription', methods: ['POST'], condition: "request.headers.get('X-Requested-With') === '%app.requested_ajax%'")]
    public function setProfessionalDescription(#[CurrentUser] Users $user, ProfessionalsRepository $professionalsRepository, Request $request, EntityManagerInterface $em, AlertService $alert, $id): JsonResponse 
    {
        if (!isset($user)) {
            return $this->json("Non authentifiée", 401);
        }

        $professional = $professionalsRepository->findOneBy(["user" => $user, "id" => $id]);

        if (!isset($professional)) {
            return $this->json("Professional not found", 400);
        }

        $data = json_decode($request->getContent(), true);

        $desc = $data["description"];

        if (!isset($desc)) {
            return $this->json("Description not found", 400);
        }

        $professional->setDescription($desc);

        try {
            $em->persist($professional);
            $em->flush();
            $alert->generate("success", "Description sauvegardée", "La description de votre compte professionnel a bien été sauvegardée.");
        } catch (\Throwable $th) {
            $alert->generate("fail", "Erreur de sauvegarde", "Une erreur s'est produite, la description de votre compte professionnel n'a pas été enregistré. Veuillez réessayer.");
        }

        return $this->json($professional, 200, context: ["groups" => "main"]);
    }

    #[Route('/ajax/professional/criteria/delete/{id}', name: 'app_deleteProfessionalCriteria', methods: ['POST'], condition: "request.headers.get('X-Requested-With') === '%app.requested_ajax%'")]
    public function deleteProfessionalCriteria(#[CurrentUser] Users $user, ProfessionalsRepository $professionalsRepository, Request $request, EntityManagerInterface $em, AlertService $alert, $id): JsonResponse 
    {
        if (!isset($user)) {
            return $this->json("Non authentifiée", 401);
        }

        $professional = $professionalsRepository->findOneBy(["user" => $user, "id" => $id]);

        if (!isset($professional)) {
            return $this->json("Professional not found", 400);
        }

        $data = json_decode($request->getContent(), true);

        $criteria = $data["criteria"];

        if (!isset($criteria)) {
            return $this->json("Criteria not found", 400);
        }

        $criterias = $professional->getCriteria();
        $arrayCriterias = [];

        foreach ($criterias as $key => $e) {
            if ($e["emoji"] == $criteria["emoji"] && $e["content"] == $criteria["content"]) {
                unset($criterias[$key]);
            } else {
                array_push($arrayCriterias, $e);
            }
        }

        $professional->setCriteria($arrayCriterias);

        try {
            $em->persist($professional);
            $em->flush();
            $alert->generate("success", "Suppression du critère", "Le critère de votre compte professionnel a bien été supprimé.");
            return $this->json($arrayCriterias, 200, context:["groups" => "main"]);
        } catch (\Throwable $th) {
            $alert->generate("fail", "Erreur de suppression", "Une erreur s'est produite, le critère de votre compte professionnel n'a pas été supprimé. Veuillez réessayer.");
            return $this->json("Delete failed", 400);
        }

    }

    #[Route('/ajax/professional/criteria/{id}', name: 'app_setProfessionalCriteria', methods: ['POST'], condition: "request.headers.get('X-Requested-With') === '%app.requested_ajax%'")]
    public function setProfessionalCriteria(#[CurrentUser] Users $user, ProfessionalsRepository $professionalsRepository, Request $request, EntityManagerInterface $em, AlertService $alert, $id): JsonResponse 
    {
        if (!isset($user)) {
            return $this->json("Non authentifiée", 401);
        }

        $professional = $professionalsRepository->findOneBy(["user" => $user, "id" => $id]);

        if (!isset($professional)) {
            return $this->json("Professional not found", 400);
        }

        $data = json_decode($request->getContent(), true);

        $emoji = $data["emoji"];
        $content = $data["content"];

        if (!isset($emoji)) {
            return $this->json("Emoji not found", 400);
        }

        if (!isset($content)) {
            return $this->json("Content not found", 400);
        }

        $criteria = $professional->getCriteria();

        if (!is_array($criteria)) {
            $criteria = [];
        }
        
        array_push($criteria, ["emoji" => $emoji, "content" => $content]);

        $professional->setCriteria($criteria);

        try {
            $em->persist($professional);
            $em->flush();
            $alert->generate("success", "Critère sauvegardée", "Le critère de votre compte professionnel a bien été sauvegardée.");
        } catch (\Throwable $th) {
            $alert->generate("fail", "Erreur de sauvegarde", "Une erreur s'est produite, le critère de votre compte professionnel n'a pas été enregistré. Veuillez réessayer.");
        }

        return $this->json($professional, 200, context: ["groups" => "main"]);
    }

    #[Route('/ajax/professional/{id}', name:'app_getProfessionalById', methods: ['GET'], condition: "request.headers.get('X-Requested-With') === '%app.requested_ajax%'")]
    public function getProfessionalById(ProfessionalsRepository $professionalsRepository, $id): JsonResponse
    {
        $professional = $professionalsRepository->findOneBy(["id" => $id]);

        if (!isset($professional)) {
            return $this->json("Professional not found", 400);
        }

        return $this->json($professional, 200, context: ["groups" => "main"]);
    }
}