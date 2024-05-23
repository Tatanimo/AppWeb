<?php 

namespace App\Controller\Ajax;

use App\Services\CalculatingDistance;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/ajax/user', name: 'app_getUser', methods: ['GET'], condition: "request.headers.get('X-Requested-With') === '%app.requested_ajax%'")]
    public function fetchUser(): JsonResponse
    {
        $user = $this->getUser();

        if (!isset($user)) {
            return $this->json("Non authentifiée", 401);
        }

        return $this->json($user, 200);
    }
}