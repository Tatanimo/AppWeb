<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Users;
use App\Services\Mercure\AlertService;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Routing\Attribute\Route;

class SecurityController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em, private AlertService $alert)
    {
        
    }
    #[Route(path: '/login', name: 'api_login', methods: ['POST'])]
    public function login(#[CurrentUser] ?Users $user): Response
    {
        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->json([
            'user' => $user->getUserIdentifier()
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/register', name: 'app_register', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new Users();
        $data = json_decode($request->getContent(), true);
        
        $email = $data["email"] ?? null;
        $password = $data['password'] ?? null;
        $firstname = $data['firstname'] ?? null;
        $lastname = $data['lastname'] ?? null;

        if (isset($email) && isset($password) && isset($firstname) && isset($lastname)) {
            // Récupère le mot de passe, le hash et l'intégre à l'utilisateur
            $hashedPassword = $passwordHasher->hashPassword($user, $password);
            $user->setPassword($hashedPassword);

            $user->setLastName($lastname)->setFirstName($firstname)->setEmail($email);
            
            // Génére le rôle utilisateur
            $user->setRoles(["ROLE_USER"]);

            try {
                // Sauvegarde l'utilisateur
                $this->em->persist($user);
                $this->em->flush();

                $this->alert->generate("success", "Compte enregistré", "Votre compte $email a bien été enregistré.");

                return $this->json('success', 200);
            } catch (\Throwable $th) {
                // Blabla erreur
                $this->alert->generate("fail", "Erreur de sauvegarde", "Une erreur s'est produite, votre compte n'a pas été enregistré. Veuillez réessayer.");
                
                return $this->json('Fail to save the user in database. The error is: '.$th, 400);
            }
        } else {
            $this->alert->generate("fail", "Erreur de sauvegarde", "Une erreur s'est produite, une ou plusieurs données sont manquantes.");
            return $this->json("Fail to fetch data, there's one or multiple missing.", 400);
        }
    }
}
