<?php

namespace App\Controller\Ajax;

use App\Entity\Appointments;
use App\Entity\Users;
use App\Repository\AnimalsRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class AppointmentsController extends AbstractController
{
    #[Route('/ajax/appointments', name: 'app_ajax_add_appointments', methods: ['POST'], condition: "request.headers.get('X-Requested-With') === '%app.requested_ajax%'")]
    public function addAppointments(#[CurrentUser()] ?Users $user, Request $request, EntityManagerInterface $em, AnimalsRepository $animalsRepository): JsonResponse
    {  
        if (!isset($user)) {
            return $this->json("Non authentifiée", 401);
        }

        $professional = $user->getProfessionals();

        if (!isset($professional)) {
            return $this->json("Professionnel non identifié", 401);
        }

        $request = json_decode($request->getContent(), true);
        $animals = $request["animals"];
        $date = $request["date"];

        foreach ($animals as $animal) {
            try {
                $appointment = new Appointments();
                $animal = $animalsRepository->findOneBy(["id" => $animal["id"]]);
                $start = new DateTime($date[0]);
                $start->modify("+1 day")->settime(0,0);
                $end = new DateTime($date[1]);
                $end->modify("+1 day")->settime(0,0);
                $appointment->setAnimal($animal)->setProfessional($professional)->setStartDate($start)->setEndDate($end);

                $em->persist($appointment);
            } catch (\Throwable $th) {
                return $this->json("Erreur dans la sauvegarde d'une prise de rendez-vous.", 401);
            }
        }

        $em->flush();

        return $this->json("Prise de rendez-vous sauvegardée.", 200);
    }
}