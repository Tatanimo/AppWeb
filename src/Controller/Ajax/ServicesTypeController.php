<?php

namespace App\Controller\Ajax;

use App\Repository\ServicesTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ServicesTypeController extends AbstractController
{
    #[Route('/ajax/servicestype', name: 'app_getServicesType', methods: ['GET'], condition: "request.headers.get('X-Requested-With') === '%app.requested_ajax%'")]
    public function fetchServicesType(ServicesTypeRepository $servicesTypeRepository): JsonResponse
    {
        $services = $servicesTypeRepository->findAll();

        if (!isset($services)) {
            return $this->json("Aucun services récupérés", 401);
        }

        return $this->json($services, 200, context: ["groups" => "main"]);
    }
}