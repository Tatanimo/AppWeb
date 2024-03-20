<?php

namespace App\Controller\Ajax;

use App\Repository\CitiesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class CitiesController extends AbstractController
{
    #[Route('/ajax/cities', name: 'app_getCities', methods: ['GET'], condition: "request.headers.get('X-Requested-With') === '%app.requested_ajax%'")]
    public function getCities(CitiesRepository $citiesRepository): JsonResponse
    {
        $cities = $citiesRepository->findAll();
        return $this->json($cities);
    }
}
