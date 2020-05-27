<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /*un commentaire qui commence avec un @ est une anotation tres importante , symfony explique lorsquon lancera www.monsite
    com/blog , on fera appel a la méthode index() 
    pas besoin de preciser templates/blog/index.html.twig , symfony sait ou se trouve les fichiers templates rendu*/
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo)
    {
        /*pour selectionner des données en bdd nous avons besoin de la class repository de la classe article
        une classe repository permet uniquement de selectionner des données en bdd requete sql select(re) 
        on a besoin de l'orm doctrine pour faire la relation entre la bdd et notre application getdoctrine
        getrepository() methode issue de l'objet Doctrine qui permet d'importer une class repository
        
        $repo est un objet issu de la classe articlerepository , cette contient des methodes predefinies par symfony  permettant de selectionner des donnee
        en bdd (find findby findoneby findall)
        dump() : équivalent de var_dump(), permet d'observer le resultat de la requete de selection en bas de la page dans la barre administrative (cible à droite)
        

     */
        
       // $repo = $this->getDoctrine()->getRepository(Article::class);
       //si on enleve les commentaire sur la ligne au dessu alors on doit enlever les argument qui se trouve dans index(ArticleRepository $repo)
        dump($repo);

        $articles = $repo->findAll();
        dump($articles);
        // findAll() est une méthode issue de la classe ArticleRepository qui permet de selectionner l'ensemble de la table (similaire à SELECT * FROM article)


        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles 
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
     * @Route("/blog/new", name="blog_create")
     */
    public function create(Request $request)
    {
        dump($request);
        return $this->render('blog/create.html.twig');      
    }

    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show(Article $article)
    {
        /*
        pour selectionner un article ds la bdd, nous utilisons le principe de route parametre
        dans la route ,on definit un parametre de type  {Id}
        LORSQUE NS transmettrons ds l'url par exple une route '/blog/6', donc on envoie un id connu en bdd dans l'url
        symfony va automatiquement recuperee ce parametre et le transmettre en argument de la methode show
        cela veut dire que ns avons acces a l'id a l'interieru de la methode show
        le but est de selectionner les donnees en bdd de l'id recupere en parametre de la methode show
        nous avons donc besoin pour cela de la classe articlerepository afin de pouvoirselectionneren bdd
        la methode find est issue de la classe articlerepository et permet de selectionner des donnees en bdd a partir
        d'un parametre de type {id}
        getdoctrine : l'orm fait le travail pour nous , cest a dire qu'elle recupere la requete de selection pour l'executer en bdd
        et doctrine recupere le resultat de la requete de selection pour l'envoiyer dans le controller

        $repo est un objet issu de la classe articlerepository nous avons acces a toutes les methodes declarees dans cette class
        find findall findby findonly etc
        */
       // $repo = $this->getDoctrine()->getRepository(Article::class);
       // $article = $repo->find($id);
        dump($article);
        

        return $this->render('blog/show.html.twig',[
            'article' =>$article
        ]);
          
        /*            doctrine
                BDD  <_______  
                |             |  
                |              CONTROLLER _______ > libère les templates + données BDD sur la navigateur
                |____________>|
                    doctrine
        */

      
    }
    //creer 1 methode create (route '/create') renvoie le template create.html.twig
    //+ un peu de contenu dans le template + test navigateur
    
    

}
