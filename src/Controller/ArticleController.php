<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function details(Article $article, Request $request){

        $comment = new Comment();
        $comment->setArticle($article)
                ->setCreatedAt(new \DateTime());

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            $this->addFlash('success', 'Votre commentaire a été enregistré');

            return $this->redirectToRoute('article-details', ['id'=> $article->getId()]);
        }

        return $this->render('article/details.html.twig', [
            'article' => $article,
            'commentForm' => $form->createView()
        ]);
    }
}
