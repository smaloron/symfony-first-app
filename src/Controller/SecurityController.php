<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    /**
     * @Route("/login-author", name="security-login")
     */
    public function authorLogin(Request $request, AuthenticationUtils $helper){

        dump($helper->getLastAuthenticationError());

        return $this->render('security/author-login.html.twig',[
            'lastUserName' => $helper->getLastUsername(),
            'error' => $helper->getLastAuthenticationError()
        ]);
    }

}