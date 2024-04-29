<?php

namespace App\Services\Twig;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FindUserImages extends AbstractExtension 
{
    public function __construct(private ParameterBagInterface $params)
    {
        
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('findUserImages', [$this, 'findUserImages']),
        ];
    }

    public function findUserImages(int $id) : array 
    {
        $userImagesFolder = $this->params->get("app.user_images_folder");
        $file = "user-$id-*";
        return glob($userImagesFolder.$file);
    }
}