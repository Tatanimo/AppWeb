<?php

namespace App\Services\Twig;

use App\Repository\AnimalsRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class Animals extends AbstractExtension 
{
    public function __construct(private AnimalsRepository $animalsRepository, private Security $security)
    {
        
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('getAnimalsUser', [$this, 'getAnimalsUser']),
        ];
    }

    public function getAnimalsUser() : array 
    {
        $user = $this->security->getUser();
        $animals = $this->animalsRepository->findBy(["fk_user" => $user]);
        return $animals;
    }
}