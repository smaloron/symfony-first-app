<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article")
 * Class ArticleController
 * @package App\Controller
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="article-list")
     */
    public function index()
    {
        $articleList = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        return $this->render('article/index.html.twig', [
            'articleList' => $articleList,
        ]);
    }

    /**
     * @Route("/{id}", name="article-details")
     */
    public function details(Article $article){

        return $this->render('article/details.html.twig', [
            'article' => $article
        ]);
    }
}
