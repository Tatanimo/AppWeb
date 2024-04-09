<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerService $mailerService): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();
            $subject = 'Demande de contact sur votre site de ' . $contactFormData['email'];
            $content = $contactFormData['lastname'] . ' ' . $contactFormData['firstname'] . ' vous a envoyé le message suivant : ' . $contactFormData['message'];
            $mailerService->sendEmail(subject: $subject, content: $content);
            $this->addFlash('success', 'Votre message a bien été envoyé! Vous recevrez une réponse dans les prochaines 24h.');
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'form_controller' => $form->createView(),
        ]);
    }
}
