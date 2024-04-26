<?php

namespace App\Controller\Ajax;

use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class UsersController extends AbstractController
{
    #[Route('/ajax/users/stats', name: 'user_stats')]
    public function userStats(UsersRepository $usersRepository): JsonResponse
    {
        $usersByDay = $usersRepository->countUsersByDay();
        //$usersByMonth = $usersRepository->countUsersByMonth();
        // $usersByYear = $usersRepository->countUsersByYear();
        $totalUsers = $usersRepository->countTotalUsers();
    
        $stats = [
            'users_by_day' => count($usersByDay),
            //'users_by_month' => count ($usersByMonth),
            // 'users_by_year' => $usersByYear,
             'total_users' => $totalUsers,
                ];

        return $this->json($stats);
     
}
}
