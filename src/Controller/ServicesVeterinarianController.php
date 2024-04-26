<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/services', name: 'app_services')]
class ServicesVeterinarianController extends AbstractController
{
    #[Route('/veterinarian', name: '_veterinarian')]
    public function index(): Response
    {
        return $this->render('services/veterinarian/index.html.twig', [
            'controller_name' => 'ServicesVeterinarianController',
        ]);
    }
}
