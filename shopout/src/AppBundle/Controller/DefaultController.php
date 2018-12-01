<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }


    /**
     * @Route("/home", name="home")
     */
    public function afficherHome()
    {
        return $this->render('@App/home.html.twig');
    }



    /**
     * @Route("/contact", name="contact")
     */
    public function afficherContact()
    {
        return $this->render('@App/contact.html.twig');
    }



    /**
     * @Route("/profil", name="profil")
     */
    public function afficherProfil(){

        return $this->render('@App/profil.html.twig');
    }
}
