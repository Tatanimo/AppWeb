<?php

namespace App\Services;

use App\Entity\Messages;
use App\Entity\Rooms;
use App\Services\Mercure\MessageService;
use App\Services\Mercure\NotificationService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class MessagesService
{
    private $request;
    private $user;

    public function __construct(private RequestStack $requestStack, private EntityManagerInterface $em, private Security $security, private NotificationService $notificationService, private MessageService $messageService){
        $this->request = $this->requestStack->getCurrentRequest();
        $this->user = $this->security->getUser();
    }

    public function appointment (Rooms $room)
    {
        $appointment = json_decode($this->request->getContent(), true)["appointment"];
    
        if (!isset($appointment)) {
            return new JsonResponse("rendez-vous non trouvé", 401);
        }
    
        if ($this->appointmentAlreadyActif($room)) {
            return;
        }

        try {
            $message = new Messages();
            $message->setAuthor($this->user)->setType("appointment")->setRooms($room)->setContent(json_encode($appointment))->setPublicationDate(new DateTime());
    
            $this->em->persist($message);
            $this->em->flush();
        } catch (\Throwable $th) {
            $response = new Response();
            $response->setContent("Une erreur s'est produite : " . $th->getMessage());
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            return $response;
        }

        $date = $message->getPublicationDate();
        $dateString = $date->format('d-m-Y H:i:s');

        $this->messageService->generate($room->getUuid(), $message->getContent(), $message->getAuthor()->getId(), $dateString, $message->getType(), $message->getId());
        $this->notificationService->generate($room->getContactId($this->user->getId()), $room->getUuid());
    }

    private function appointmentAlreadyActif ($room) : bool
    {
        $messages = $room->getFkMessage()->toArray();
        $recentMessages = array_reverse($messages);
        $typeArray = $this->getTypes($recentMessages);
        $key = array_search("answered-appointment", $typeArray);
        $answered = null;

        if ($key !== false) {
            $answered = $recentMessages[$key];
        }

        foreach ($recentMessages as $message) {
            if ($message->getType() == "appointment") {
                if (isset($answered)) {
                    return $answered->getPublicationDate() < $message->getPublicationDate();
                } else {
                    return true;
                }
            }
        }

        return false;
    }

    private function getTypes($messages) {
        $types = [];
        foreach ($messages as $message) {
            $types[] = $message->getType();
        }
        return $types;
    }
}