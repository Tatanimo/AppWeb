<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ComponentsController extends AbstractController
{
    #[Route('/admin/components', name: 'app_admin_components')]
    public function index(): Response
    {

        return $this->render('admin/components/index.html.twig', [
            'controller_name' => 'ComponentsController',
        ]);
    }
}
