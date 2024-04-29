<?php

namespace App\Controller\Ajax;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ProfileController extends AbstractController 
{
    #[Route('/ajax/profile/{id}/{number}', name: 'app_ajax_add_image_profile', methods: ['POST'], condition: "request.headers.get('X-Requested-With') === '%app.requested_ajax%'")]
    public function addRoom(#[CurrentUser()] ?Users $user, Request $request, $id, $number): JsonResponse
    {
        if (!isset($user)) {
            return $this->json("Non authentifiée", 401);
        }
        
        if ($id != $user->getId()) {
            return $this->json("Non autorisé", 401);
        }

        $uploadedFile = $request->files->get('file');
        if (!isset($uploadedFile)) {
            return $this->json("Fichier non trouvé", 401);
        }
        
        $ext = $uploadedFile->guessExtension();
        $newFilename = "user-".$user->getId().'-'.$number.'.'.$ext;
        
        $destination = $this->getParameter('kernel.project_dir') . '/public/img/users/';
        try {
            $uploadedFile->move($destination, $newFilename);
        } catch (FileException $e) {
            return $this->json($e, 400);
        }
        
        return $this->json($ext, 200);
    }
}