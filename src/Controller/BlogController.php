<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /*un commentaire qui commence avec un @ est une anotation tres importante , symfony explique lorsquon lancera www.monsite
    com/blog , on fera appel a la méthode index() 
    pas besoin de preciser templates/blog/index.html.twig , symfony sait ou se trouve les fichiers templates rendu*/
    /**
     * @Route("/blog", name="blog")
     */
    public function index()
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('blog/home.html.twig',[
            'title' =>'Bienvenue sur le blog Symfony',
            'age' => 25
        ]);
      
    }

}
