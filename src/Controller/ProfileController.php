<?php

namespace App\Controller;

use App\Entity\Users;
use App\Services\Mercure\AlertService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ProfileController extends AbstractController
{
    #[Route('/profil', name: 'app_profile')]
    public function index(#[CurrentUser] ?Users $user, Request $request, AlertService $alert): Response
    {
        if (!isset($user)) {
            $this->addFlash('fail', ['title' => 'Erreur', 'message' => "Vous n'avez pas accès au profil sans être connecté."]);
            return $this->redirectToRoute("app_home");
        }

        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }
}
