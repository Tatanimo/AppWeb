<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegisterType;
use App\Repository\CitiesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
        
    }
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/register', name: 'app_register')]
    public function register(Request $request, CitiesRepository $citiesRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new Users();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            $requestCity = $request->request->get('city');
            if ($form->isValid() && $requestCity != null) {
                // Récupère la ville et l'intégre à l'utilisateur
                $city = $citiesRepository->findOneByRequest($requestCity);
                $user->setCities($city);

                // Récupère le mot de passe, le hash et l'intégre à l'utilisateur
                $password = $form->get('password')->getData();
                $hashedPassword = $passwordHasher->hashPassword($user, $password);
                $user->setPassword($hashedPassword);
                
                // Génére le rôle utilisateur
                $user->setRoles(["ROLE_USER"]);

                try {
                    // Sauvegarde l'utilisateur
                    $this->em->persist($user);
                    $this->em->flush();
                    $this->addFlash('success', ['title' => 'Compte enregistré', 'message' => "Votre compte a bien été enregistré."]);
                    return $this->redirectToRoute('app_login');
                } catch (\Throwable $th) {
                    // Blabla erreur
                    $this->addFlash('fail', ['title' => 'Erreur de sauvegarde', 'message' => "Une erreur s'est produite, votre compte n'a pas été enregistré. Veuillez réessayer."]);
                }

            }
        }
        
        return $this->render('security/register.html.twig', [
            'formRegister' => $form,
        ]);
    }
}
