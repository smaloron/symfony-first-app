<?php

namespace App\Controller;

use App\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_index")
     */
    public function index()
    {
        $articleList = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        return $this->render('admin/index.html.twig', [
            'articleList' => $articleList,
        ]);
    }

    /**
     * @Route("/admin/heaven", name="gate-to-heaven")
     */
    public function gateToHeaven(){
        $this->render('admin/gate-to-heaven.html.twig');
    }

    /**
     * @Route(  "/admin/delete-article/{id}",
     *          name="article-delete",
     *          requirements={"id"="\d+"}
     * )
     *
     * @IsGranted("ROLE_ADMIN")
     *
     * @param Article $article
     * @return RedirectResponse
     */
    public function deleteArticle(Article $article){
        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute('admin_index');
    }
}
