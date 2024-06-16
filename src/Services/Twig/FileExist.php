<?php

namespace App\Services\Twig;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FileExist extends AbstractExtension 
{
    public function __construct(private ParameterBagInterface $params)
    {
        
    }

    public function getFunctions() : array
    {
        return [
            new TwigFunction('fileExist', [$this, 'fileExist']),
        ];
    }

    public function fileExist(string $file) : string 
    {
        $publicFolder = $this->params->get("app.public_folder");
        return file_exists($publicFolder.$file);
    }
}