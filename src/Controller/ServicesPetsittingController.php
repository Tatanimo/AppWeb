<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Form\SearchPetsitterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/services', name: 'app_services')]
class ServicesPetsittingController extends AbstractController
{
    #[Route('/petsitting', name: '_petsitting')]
    public function index(): Response
    {
        return $this->render('services/petsitting/index.html.twig');
    }
}
