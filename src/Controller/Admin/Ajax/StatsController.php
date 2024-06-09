<?php

namespace App\Controller\Admin\Ajax;

use App\Repository\RatingsWebsiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class StatsController extends AbstractController
{
    #[Route('/admin/ajax/ratings/total-rating', name: 'stats_active_users')]
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
}
