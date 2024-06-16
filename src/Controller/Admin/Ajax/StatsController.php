<?php

namespace App\Controller\Admin\Ajax;

use App\Repository\RatingsWebsiteRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class StatsController extends AbstractController
{
    #[Route('/admin/ajax/stats/total-rating', name: 'stats_active_users')]
    public function getTotalRating(RatingsWebsiteRepository $ratingsWebsiteRepository): JsonResponse
    {
        $ratings = $ratingsWebsiteRepository->findAll();
        $totalRating = 0;

        $ratingsCount = count($ratings);

        foreach ($ratings as $rating) {
            $totalRating += $rating->getRating();
        }

        $totalRating = $totalRating / $ratingsCount;

        $totalRating = round($totalRating, 1);

        return $this->json($totalRating);
    }

    #[Route('/admin/ajax/stats/total-account-created', name: 'stats_total_account_created')]
    public function getTotalAccountCreated(UsersRepository $usersRepository): JsonResponse
    {
        $users = $usersRepository->findAll();
        $totalUsers = count($users);

        return $this->json($totalUsers);
    }

    #[Route('/admin/ajax/stats/monthly-account-created', name: 'stats_since_one_month_account_created')]
    public function getAccountCreatedSinceOneMonth(UsersRepository $usersRepository): JsonResponse
    {
        $users = $usersRepository->findSinceOneMonth();

        $totalUsers = count($users);

        return $this->json($totalUsers);
    }
}
