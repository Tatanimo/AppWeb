<?php

namespace App\Controller\Ajax;

use App\Entity\Rooms;
use App\Entity\Users;
use App\Repository\MessagesRepository;
use App\Repository\RoomsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class MessagesController extends AbstractController
{
    #[Route('/ajax/messages', name: 'app_ajax_add_messages', methods: ['POST'], condition: "request.headers.get('X-Requested-With') === '%app.requested_ajax%'")]
    public function addRoom(#[CurrentUser] ?Users $user, Request $request, EntityManagerInterface $em, RoomsRepository $roomsRepository): JsonResponse
    {
        if (!isset($user)) {
            return $this->json("Non authentifiée", 401);
        }
        
        $petsitter = json_decode($request->getContent(), true)["petsitter"];

        if (!isset($petsitter)) {
            return $this->json("petsitter non trouvée", 401);
        }

        $reference = $user->getId() < $petsitter ? $user->getId().'-'.$petsitter : $petsitter.'-'.$user->getId();

        $roomAlreadyExist = $roomsRepository->findOneBy(["reference" => $reference]);

        if (isset($roomAlreadyExist)) {
            return $this->json($roomAlreadyExist->getUuid(), 200);
        }

        try {
            $room = new Rooms();
    
            $room->setReference($reference)->setUuid(Uuid::v3(Uuid::fromString(Uuid::NAMESPACE_OID), $reference));
    
            $em->persist($room);
            $em->flush();
        } catch (\Throwable $th) {
            return $this->json("Erreur dans la génération de la room: $th", 401);
        }

        return $this->json($room->getUuid(), 200);
    }

    #[Route('/ajax/messages/{uuid}', name: 'app_ajax_get_messages', methods: ['GET'], condition: "request.headers.get('X-Requested-With') === '%app.requested_ajax%'")]
    public function getMessages(#[CurrentUser] ?Users $user, MessagesRepository $messagesRepository, RoomsRepository $roomsRepository, $uuid): JsonResponse
    {
        if (!isset($user)) {
            return $this->json("Non authentifiée", 401);
        }

        $room = $roomsRepository->findOneBy(["uuid" => $uuid]);
        $messages = $messagesRepository->findBy(["rooms" => $room]);
        
        return $this->json($messages, 200, context: ['groups'=>'message']);
    }
}
