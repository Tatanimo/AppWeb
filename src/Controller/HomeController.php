<?php

namespace App\Controller;

use App\Entity\Reviews;
use App\Repository\ReactionsRepository;
use App\Repository\ReviewsRepository;
use App\Repository\UsersRepository;
use App\Services\UuidSession;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\Authorization;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, Authorization $auth, UuidSession $uuidSession): Response
    {
        $auth->setCookie($request, ["http://localhost:3000/alerts/{$uuidSession->sessionUuid()}"]);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
