<?php

namespace App\Services\Twig;

use App\Repository\CategoryAnimalsRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CategoriesAnimals extends AbstractExtension 
{
    public function __construct(private CategoryAnimalsRepository $categoriesAnimalsRepository)
    {
        
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('categoriesAnimals', [$this, 'categoriesAnimals']),
        ];
    }

    public function categoriesAnimals() : array 
    {
        $animals = $this->categoriesAnimalsRepository->findAll();
        return $animals;
    }
}