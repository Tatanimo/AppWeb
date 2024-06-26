<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\ProfessionalsRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/profil')]
class ProfileController extends AbstractController
{
    #[Route('/professionnel/{id}', name: 'app_profile_pro')]
    public function professional($id, ProfessionalsRepository $professionalsRepository): Response
    {
        $professional = $professionalsRepository->findOneBy(["id" => $id]);

        if (!isset($professional)) {
            $this->addFlash('fail', ['title' => 'Erreur', 'message' => "Ce profil n'existe pas."]);
            return $this->redirectToRoute("app_home");
        }

        switch ($professional->getService()->getType()) {
            case 'petsitter':
                return $this->render('profile/petsitter.html.twig', [
                    'professional' => $professional,
                ]);
                break;
            
            default:
                return $this->render('profile/petsitter.html.twig', [
                    'professional' => $professional,
                ]);
                break;
        }
    }

    #[Route('/{id}', name: 'app_profile')]
    public function index(#[CurrentUser] ?Users $user, $id, UsersRepository $usersRepository): Response
    {
        $profil = $usersRepository->findOneBy(["id" => $id]);

        return $this->render('profile/index.html.twig', [
            'profil' => $profil,
        ]);
    }
}
