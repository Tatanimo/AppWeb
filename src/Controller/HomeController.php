<?php

namespace App\Controller;

use App\Entity\RatingsWebsite;
use App\Repository\RatingsWebsiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(RatingsWebsiteRepository $ratingsWebsiteRepository, Request $request, EntityManagerInterface $em): Response
    {
        $ratings = $ratingsWebsiteRepository->findBy([], ['id' => 'DESC'], 10);
        $method = $request->getMethod();

        if ($method === 'POST') {
            $user = $this->getUser();
            $rating = $request->request->get('rating');
            $comment = $request->request->get('comment');
            
            if ($rating >= 1 && $rating <= 5 && $user) {
                $ratingWebsite = $ratingsWebsiteRepository->findOneBy(["user" => $user]) ?? new RatingsWebsite();
                $ratingWebsite->setRating(intval($rating))->setComment($comment)->setUser($user);
                $em->persist($ratingWebsite);
                $em->flush();
            }

            return $this->redirectToRoute('app_home');
        }

        return $this->render('home/index.html.twig', [
            'ratings' => $ratings,
        ]);
    }
}
