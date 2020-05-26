<?php

namespace App\Controller;

use App\Entity\Article;
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
        /*pour selectionner des données en bdd nous avons besoin de la class repository de la classe article
        une classe repository permet uniquement de selectionner des données en bdd requete sql select(re) 
        on a besoin de l'orm doctrine pour faire la relation entre la bdd et notre application getdoctrine
        getrepository() methode issue de l'objet Doctrine qui permet d'importer une class repository
        
        $repo est un objet issu de la classe articlerepository , cette contient des methodes predefinies par symfony  permettant de selectionner des donnee
        en bdd (find findby findoneby findall)
        dump() : équivalent de var_dump(), permet d'observer le resultat de la requete de selection en bas de la page dans la barre administrative (cible à droite)
        

     */
        
        $repo = $this->getDoctrine()->getRepository(Article::class);
        dump($repo);

        $articles = $repo->findAll();
        dump($articles);
        // findAll() est une méthode issue de la classe ArticleRepository qui permet de selectionner l'ensemble de la table (similaire à SELECT * FROM article)


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
    /**
     * @Route("/blog/45", name="blog_show")
     */
    public function show()
    {
        return $this->render('blog/show.html.twig');
      
    }
    //creer 1 methode create (route '/create') renvoie le template create.html.twig
    //+ un peu de contenu dans le template + test navigateur
    
    /**
     * @Route("/create", name="create")
     */
    public function create()
    {
        return $this->render('blog/create.html.twig');
      
    }

}
