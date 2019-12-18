<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    /**
     * @Route("/login-author", name="security-login")
     * @param AuthenticationUtils $helper
     * @return Response
     */
    public function authorLogin(AuthenticationUtils $helper){

        return $this->render('security/login.html.twig',[
            'lastUserName' => $helper->getLastUsername(),
            'error' => $helper->getLastAuthenticationError(),
            'formTitle' => 'Identification des auteurs',
            'formAction' => $this->generateUrl('author-login-check')
        ]);
    }

    /**
     * @Route("/login-admin", name="admin-login")
     * @param AuthenticationUtils $helper
     * @return Response
     */
    public function adminLogin(AuthenticationUtils $helper){
        return $this->render('security/login.html.twig',[
            'lastUserName' => $helper->getLastUsername(),
            'error' => $helper->getLastAuthenticationError(),
            'formTitle' => 'Identification des administrateurs',
            'formAction' => $this->generateUrl('admin-login-check')
        ]);
    }

}