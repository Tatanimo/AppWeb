<?php 

namespace App\Controller\Ajax;

use App\Entity\Professionals;
use App\Repository\CitiesRepository;
use App\Repository\ServicesTypeRepository;
use App\Services\CalculatingDistance;
use App\Services\Mercure\AlertService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

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
}