<?php

namespace App\Controller\Admin\Ajax;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ImageController extends AbstractController
{
    #[Route('/ajax/admin/image/{id}', name: 'app_ajax_admin_add_image_profile', methods: ['POST'], condition: "request.headers.get('X-Requested-With') === '%app.requested_ajax%'")]
    public function addImage(Request $request, $id): JsonResponse
    {
        $uploadedFile = $request->files->get('file');
        if (!isset($uploadedFile)) {
            return $this->json("Fichier non trouvé", 401);
        }

        $newFilename = $id.".".$uploadedFile->guessExtension();
        
        $destination = $this->getParameter('kernel.project_dir') . "/public/img/editable/";

        foreach (glob($destination . $id . ".*") as $file) {
            unlink($file);
        }

        try {
            $uploadedFile->move($destination, $newFilename);
        } catch (FileException $e) {
            return $this->json($e, 400);
        }
        
        return $this->json("Image sauvegardée", 200);
    }
}