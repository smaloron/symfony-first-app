<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Author;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

        $params = $this->getTwigParametersWithAside(
            ['articleList' => $articleList, 'pageTitle' => '']
        );

        return $this->render('article/index.html.twig', $params);
    }

    /**
     * @Route("/by-author/{id}", name="article-by-author")
     */
    public function showByAuthor(Author $author){
        $articleList = $this->getDoctrine()
                            ->getRepository(Article::class)
                            ->getAllByAuthor($author);

        $params = $this->getTwigParametersWithAside(
            ['articleList' => $articleList, 'pageTitle' => "de l'auteur : ". $author->getFullName()]
        );

        return $this->render('article/index.html.twig', $params);
    }

    private function getTwigParametersWithAside($data){
        $asideData = [
            'authorList' => $this->getDoctrine()
                ->getRepository(Author::class)
                ->findAll()
        ];

        return array_merge($data, $asideData );
    }

    /**
     * @Route("/{id}", name="article-details", requirements={"id"="\d+"})
     * @param Article $article
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws \Exception
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

    /**
     * @Route("/new", name="article-new")
     * @param Request $request
     * @param null $id
     * @return Response
     */
    public function addOrEdit(Request $request, $id=null){
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            $this->addFlash('success', "Votre article a été ajouté");

            return $this->redirectToRoute('article-list');
        }

        return $this->render('article/form.html.twig', [
            'articleForm' => $form->createView()
        ]);
    }
}
