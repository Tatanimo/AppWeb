<?php

namespace App\Controller\Ajax;

use App\Entity\Messages;
use App\Entity\Rooms;
use App\Entity\Users;
use App\Repository\MessagesRepository;
use App\Repository\ProfessionalsRepository;
use App\Repository\RoomsRepository;
use App\Repository\UsersRepository;
use App\Services\Mercure\MessageService;
use App\Services\Mercure\NotificationService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class MessagesController extends AbstractController
{
    #[Route('/ajax/messages', name: 'app_ajax_add_messages', methods: ['POST'], condition: "request.headers.get('X-Requested-With') === '%app.requested_ajax%'")]
    public function addRoom(#[CurrentUser] ?Users $user, Request $request, EntityManagerInterface $em, RoomsRepository $roomsRepository, UsersRepository $usersRepository): JsonResponse
    {
        if (!isset($user)) {
            return $this->json("Non authentifiée", 401);
        }
        
        $contact = json_decode($request->getContent(), true)["contact"];

        if (!isset($contact)) {
            return $this->json("contact non trouvée", 401);
        }

        $reference = $user->getId() < $contact ? $user->getId().'-'.$contact : $contact.'-'.$user->getId();

        $roomAlreadyExist = $roomsRepository->findOneBy(["reference" => $reference]);

        if (isset($roomAlreadyExist)) {
            return $this->json($roomAlreadyExist->getUuid(), 200);
        }

        $appointment = json_decode($request->getContent(), true)["appointment"];

        if (!isset($appointment)) {
            return $this->json("rendez-vous non trouvé", 401);
        }

        try {
            $room = new Rooms();
            $room->setReference($reference)->setUuid(Uuid::v3(Uuid::fromString(Uuid::NAMESPACE_OID), $reference));
    
            $em->persist($room);
            $em->flush();
        } catch (\Throwable $th) {
            return $this->json("Erreur dans la génération de la room: $th", 401);
        }

        try {
            $message = new Messages();
            
            $message->setAuthor($user)->setType("appointment")->setRooms($room)->setContent(json_encode($appointment))->setPublicationDate(new DateTime());

            $em->persist($message);
            $em->flush();
        } catch (\Throwable $th) {
            return $this->json("Erreur dans la génération du message: $th", 401);
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

    #[Route('/ajax/messages/{uuid}', name: 'app_ajax_post_messages', methods: ['POST'], condition: "request.headers.get('X-Requested-With') === '%app.requested_ajax%'")]
    public function addMessage(#[CurrentUser] ?Users $user, Request $request, EntityManagerInterface $em, RoomsRepository $roomsRepository, MessageService $messageService, $uuid, NotificationService $notificationService): JsonResponse
    {
        if (!isset($user)) {
            return $this->json("Non authentifiée", 401);
        }

        $message = json_decode($request->getContent(), true)["message"];

        if (!isset($message)) {
            return $this->json("Contenu du message non trouvable", 401);
        }
        
        try {
            $newMessage = new Messages();
            
            $date = new DateTime($message["publication_date"]);
            
            $room = $roomsRepository->findOneBy(["uuid" => $uuid]);
            $newMessage->setRooms($room)->setAuthor($user)->setPublicationDate($date)->setContent($message["content"])->setType("message");
            
            $em->persist($newMessage);
            $em->flush();
        } catch (\Throwable $th) {
            return $this->json("Erreur lors de l'envoie du message: $th", 401);
        }

        if(!$messageService->generate($uuid, $message["content"], $message["author"], $message["publication_date"], "message", $newMessage->getId())){
            return $this->json("Erreur dans l'envoie du message", 401);
        }

        if (!$notificationService->generate($room->getContactId($user->getId()), $uuid)) {
            return $this->json("Erreur dans l'envoie de la notification", 401);
        }
        
        return $this->json("Message bien envoyé", 200);
    }

    #[Route('/ajax/messages/file/{uuid}', name: 'app_ajax_post_file', methods: ['POST'], condition: "request.headers.get('X-Requested-With') === '%app.requested_ajax%'")]
    public function addFile(#[CurrentUser] ?Users $user, Request $request, EntityManagerInterface $em, RoomsRepository $roomsRepository, MessageService $messageService, $uuid, NotificationService $notificationService): JsonResponse
    {
        if (!isset($user)) {
            return $this->json("Non authentifiée", 401);
        }

        $file = $request->files->get('file');

        if (!isset($file)) {
            return $this->json("Fichier introuvable", 401);
        }

        $ext = $request->request->get("ext");

        if (!isset($ext)) {
            return $this->json("Extension introuvable", 401);
        }
        
        try {
            $newMessage = new Messages();
            
            $date = new DateTime();
            
            $room = $roomsRepository->findOneBy(["uuid" => $uuid]);
            $newMessage->setRooms($room)->setAuthor($user)->setPublicationDate($date)->setContent("")->setType($ext == "pdf" ? "pdf" : "image");
            
            $em->persist($newMessage);
            $em->flush();
        } catch (\Throwable $th) {
            return $this->json("Erreur lors de l'envoie du message: $th", 401);
        }

        $ext = $ext == "pdf" ? "pdf" : "jpg";
        $to = $ext == "pdf" ? "pdf" : "img";
        
        $newFilename = $user->getId().'-'.$newMessage->getId().'.'.$ext;
        $destination = $this->getParameter('kernel.project_dir') . "/public/" . $to . "/messages/";
        try {
            $file->move($destination, $newFilename);
        } catch (FileException $e) {
            return $this->json($e, 400);
        }

        $date = $newMessage->getPublicationDate();
        $dateString = $date->format('d-m-Y H:i:s');

        if(!$messageService->generate($uuid, $newMessage->getContent(), $newMessage->getAuthor()->getId(), $dateString, $newMessage->getType(), $newMessage->getId())){
            return $this->json("Erreur dans l'envoie du message", 401);
        }

        if (!$notificationService->generate($room->getContactId($user->getId()), $uuid)) {
            return $this->json("Erreur dans l'envoie de la notification", 401);
        }
        
        return $this->json("Fichier bien envoyé", 200);
    }

    #[Route('/ajax/messages/appointment/{uuid}', name: 'app_ajax_post_appointment_message', methods: ['POST'], condition: "request.headers.get('X-Requested-With') === '%app.requested_ajax%'")]
    public function addAppointment(#[CurrentUser] ?Users $user, Request $request, EntityManagerInterface $em, RoomsRepository $roomsRepository, MessageService $messageService, $uuid, NotificationService $notificationService): JsonResponse
    {
        if (!isset($user)) {
            return $this->json("Non authentifiée", 401);
        }

        $appointment = json_decode($request->getContent(), true)["appointment"];

        if (!isset($appointment)) {
            return $this->json("Contenu du rendez-vous non trouvable", 401);
        }

        $type = json_decode($request->getContent(), true)["type"];
        
        try {
            $newMessage = new Messages();
            
            $date = new DateTime();
            
            $room = $roomsRepository->findOneBy(["uuid" => $uuid]);
            $newMessage->setRooms($room)->setAuthor($user)->setPublicationDate($date)->setContent(json_encode($appointment))->setType($type);
            
            $em->persist($newMessage);
            $em->flush();
        } catch (\Throwable $th) {
            return $this->json("Erreur lors de l'envoie du message: $th", 401);
        }

        $date = $newMessage->getPublicationDate();
        $dateString = $date->format('d-m-Y H:i:s');

        if(!$messageService->generate($uuid, $newMessage->getContent(), $newMessage->getAuthor()->getId(), $dateString, $type, $newMessage->getId())){
            return $this->json("Erreur dans l'envoie du message", 401);
        }

        if (!$notificationService->generate($room->getContactId($user->getId()), $uuid)) {
            return $this->json("Erreur dans l'envoie de la notification", 401);
        }
        
        return $this->json("Message bien envoyé", 200);
    }

    #[Route('/ajax/messages/update/{id}', name: 'app_ajax_update_message', methods: ['POST'], condition: "request.headers.get('X-Requested-With') === '%app.requested_ajax%'")]
    public function updateMessage(#[CurrentUser] ?Users $user, Request $request, EntityManagerInterface $em, RoomsRepository $roomsRepository, MessagesRepository $messagesRepository, $id): JsonResponse
    {
        if (!isset($user)) {
            return $this->json("Non authentifiée", 401);
        }

        $appointment = json_decode($request->getContent(), true)["appointment"];

        if (!isset($appointment)) {
            return $this->json("rendez-vous non trouvé", 401);
        }
        
        try {
            $message = $messagesRepository->findOneBy(["id" => $id]);

            $message->setContent(json_encode($appointment));
            
            $em->persist($message);
            $em->flush();
        } catch (\Throwable $th) {
            return $this->json("Erreur lors de la modification du message: $th", 401);
        }
        
        return $this->json("Message bien modifié", 200);
    }
}
