<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, UsersRepository $usersRepository): Response
    {
        $faker = Factory::create('fr_FR');
        $randWords = rand(1, 5);
        dd($faker->words($randWords), ["ROLE_ADMIN"]);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
