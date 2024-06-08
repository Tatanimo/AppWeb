<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(ArticlesRepository $articlesRepository): Response
    {
        $articles = $articlesRepository->findBy([], ['publication_date' => 'DESC']);
        $dateNow = new DateTime();

        return $this->render('blog/index.html.twig', [
            'articles' => $articles,
            'dateNow' => $dateNow,
        ]);
    }

    #[Route('/blog/{slug}', name: 'app_detail_article')]
    public function details($slug, ArticlesRepository $articlesRepository): Response
    {
        $article = $articlesRepository->findOneBy(["slug" => $slug]);

        return $this->render('blog/slug/index.html.twig', [
            'article' => $article,
        ]);
    }
}
