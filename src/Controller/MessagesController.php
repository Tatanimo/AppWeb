<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\ProfessionalsRepository;
use App\Repository\RoomsRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class MessagesController extends AbstractController
{
    #[Route('/messages', name: 'app_messages', methods: ["GET"])]
    public function index(#[CurrentUser] ?Users $user, RoomsRepository $roomsRepository, UsersRepository $usersRepository): Response
    {
        if (!isset($user)) {
            $this->addFlash('fail', ['title' => 'Erreur', 'message' => "Vous n'avez pas accès à la messagerie sans être connecté."]);
            return $this->redirectToRoute("app_home");
        }

        $rooms = $roomsRepository->findByReferenceId($user->getId());
        $contacts = [];
        foreach ($rooms as $room) {
            $ids = explode("-", $room->getReference());
            $id = array_filter($ids, function($e) use($user) {
                return $e != $user->getId();
            });
            $contact = $usersRepository->findOneBy(["id" => $id]);
            array_push($contacts, $contact);
        }

        return $this->render('messages/index.html.twig', [
            "rooms" => $rooms,
            "contacts" => $contacts
        ]);
    }
    
    #[Route('/messages/{uuid}', name: 'app_chat')]
    public function chat(#[CurrentUser] ?Users $user, RoomsRepository $roomsRepository, $uuid, UsersRepository $usersRepository, ProfessionalsRepository $professionalsRepository): Response
    {
        if (!isset($user)) {
            $this->addFlash('fail', ['title' => 'Erreur', 'message' => "Vous n'avez pas accès à la messagerie sans être connecté."]);
            return $this->redirectToRoute("app_home");
        }

        $rooms = $roomsRepository->findOneBy(["uuid" => $uuid]);

        if (!isset($rooms)) {
            $this->addFlash('fail', ['title' => 'Erreur', 'message' => "Messagerie introuvable."]);
            return $this->redirectToRoute("app_home");
        }

        if (!str_contains($rooms->getReference(), $user->getId())) {
            $this->addFlash('fail', ['title' => 'Erreur', 'message' => "Messagerie introuvable."]);
            return $this->redirectToRoute("app_home");
        }

        $explodeReference = explode("-", $rooms->getReference());
        $contact = null;
        foreach ($explodeReference as $value) {
            if ($value != $user->getId()) {
                $contact = $value;
            }
        }

        $contact = $usersRepository->findOneBy(["id" => $contact]);
        
        return $this->render('messages/chat.html.twig', [
            "contact" => $contact,
            "uuid" => $uuid,
            "rooms" => $rooms
        ]);
    }
}
