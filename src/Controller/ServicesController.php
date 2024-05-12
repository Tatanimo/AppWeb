<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/services', name: 'app_services')]
class ServicesController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(): Response
    {
        return $this->render('services/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }

    #[Route('/petsitting', name: '_petsitting')]
    public function petsitting(): Response
    {
        return $this->render('services/petsitting/index.html.twig');
    }

    #[Route('/veterinarian', name: '_veterinarian')]
    public function veterinarian(): Response
    {
        return $this->render('services/veterinarian/index.html.twig', [
            'controller_name' => 'ServicesVeterinarianController',
        ]);
    }
}
