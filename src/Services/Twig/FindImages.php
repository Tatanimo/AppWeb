<?php

namespace App\Services\Twig;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FindImages extends AbstractExtension 
{
    public function __construct(private ParameterBagInterface $params)
    {
        
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('findUserImages', [$this, 'findUserImages']),
            new TwigFunction('findAnimalImages', [$this, 'findAnimalImages']),
            new TwigFunction('findProfessionalImage', [$this, 'findProfessionalImage']),
            new TwigFunction('findEditableImage', [$this, 'findEditableImage']),
        ];
    }

    public function findProfessionalImage(int $id) : bool 
    {
        $professionalImagesFolder = $this->params->get("app.professionals_images_folder");
        $file = "professional-$id-1.jpg";
        $file = glob($professionalImagesFolder.$file);
        if (count($file) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function findUserImages(int $id) : array 
    {
        $userImagesFolder = $this->params->get("app.user_images_folder");
        $file = "user-$id-*";
        return glob($userImagesFolder.$file);
    }

    public function findAnimalImages(int $id) : array 
    {
        $animalsImagesFolder = $this->params->get("app.animals_images_folder");
        $file = "animal-$id-*";
        return glob($animalsImagesFolder.$file);
    }

    public function findEditableImage(string $id) : array 
    {
        $editableImagesFolder = $this->params->get("app.editable_images_folder");
        $file = "$id.*";
        return glob($editableImagesFolder.$file);
    }
}