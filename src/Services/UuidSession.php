<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class UuidSession extends AbstractExtension {
    public function __construct(private RequestStack $requestStack)
    {
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('sessionUuid', [$this, 'sessionUuid']),
        ];
    }

    public function sessionUuid() : string 
    {
        $session = $this->requestStack->getSession();
        return $session->get("uuid")->toRfc4122();
    }
}