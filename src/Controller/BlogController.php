<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(ArticlesRepository $articlesRepository): Response
    {
        $articles = $articlesRepository->findAll();

        return $this->render('blog/index.html.twig', [
            'articles' => $articles,
        ]);
    }
}
