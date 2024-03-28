<?php

namespace App\Controller\Ajax;

use App\Repository\CitiesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class CitiesController extends AbstractController
{
    #[Route('/ajax/cities/{query}', name: 'app_getCities', methods: ['GET'], condition: "request.headers.get('X-Requested-With') === '%app.requested_ajax%'")]
    public function getCities(CitiesRepository $citiesRepository, $query): JsonResponse
    {
        if (preg_match('/\d/', $query)) {
            $name = trim(preg_replace('/\d/', '', $query));
            $zipCode = trim(preg_replace('/\D/', '', $query));
            $cities = $citiesRepository->findByNameAndZipCode($name, $zipCode);
        } else {
            $cities = $citiesRepository->findByName($query);
        }

        return $this->json($cities, 200, context:['groups' => 'main']);
    }
}
