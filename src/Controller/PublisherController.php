<?php

namespace App\Controller;

use App\Entity\Publisher;
use App\Form\PublisherType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PublisherController extends AbstractController
{
    /**
     * @Route("/publishers", name="publisher-list")
     */
    public function index()
    {
        $publisherList = $this->getDoctrine()
            ->getRepository(Publisher::class)
            ->findAll();

        return $this->render('publisher/index.html.twig', [
            'publisherList' => $publisherList,
        ]);
    }

    /**
     * @Route("/publisher/new", name="publisher-new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addEdit(Request $request){
        $publisher = new Publisher();

        $form = $this->createForm(
            PublisherType::class,
            $publisher
        );

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($publisher);
            $em->flush();

            return $this->redirectToRoute('publisher-list');
        }

        return $this->render('/publisher/form.html.twig', [
            'publisherForm' => $form->createView()
        ]);
    }
}
