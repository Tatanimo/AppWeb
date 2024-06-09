<?php

namespace App\Services\Twig;

use App\Entity\RatingsWebsite;
use App\Repository\RatingsWebsiteRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ReviewWebsite extends AbstractExtension 
{
    public function __construct(private Security $security, private RatingsWebsiteRepository $ratingsWebsiteRepository)
    {
        
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('ratingIssued', [$this, 'ratingIssued']),
        ];
    }

    public function ratingIssued() : ?RatingsWebsite 
    {
        $user = $this->security->getUser();
        return $this->ratingsWebsiteRepository->findOneBy(["user" => $user]);
    }
}