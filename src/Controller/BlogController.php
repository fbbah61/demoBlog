<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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

    /*on declare une route permettant d'inserre un article '/blog/new'
    on declare une route parametre '/blog/{id}/edit' permettant de modifier un article
    
    si nous envoyons un {id} dans l'url, symfony est capable d'aller selectionner en bdd les donnees de l'article, donc
    l'objet $article nest plus null
    si nous envoyons dans l'url , a ce moment là $article est bien null*/

    /**
     * @Route("/blog/new", name="blog_create")
     * @Route("/blog/{id}/edit", name="blog_edit")
     */
    public function form(Article $article = null, Request $request , EntityManagerInterface $manager)
    {
        //initialement methode create()


        /*la class request est une classe predefinie en symfony qui stockent toutes les donnees vehiculees par les superglobales
        ($_GET $_POST $_SERVER ...)
         la prorpiete request represente la superglobale $_POST , les donnees saisies dans le formulaire sont accessibles via cette
         proprite ça renvoie des parametres (sac de parametres)
         pour inserre un nvel article , nous devons instancier la class pour avoir un article vide , toutes les propriete private
         ($titre,$content,$image) ils faut donc les remplir , pour cela nous faisons appel au setter
         
         entitymanagerinterface est une methode predefinie de symfonie qui permet de manipuler les liges de la bdd(insert , update
         
         persist est une methode issue de la class entitymanagerinterface qui permet de stocker et de preparer la requete sql
         d'insertion
         
         flush est une methode issue de la classe entitymanagerinterface qui permet de liberer la requete d'insertion,c'est elle
         qui envoie veritablement dans la bdd
         
         redirectoroute methode predefinie de symfony qui permet de rediriger vers une route specifique , dans notre cas on redirige
         apres insertion vers la route blog_show(avec le bon dernier id inserer ) affin de renvoyer vers le detail de l'article qui
         vient d'etre inserer*/
        dump($request);
        // if($request->request->count() >0)
        // {
        //     $article = new Article;
        //     $article->setTitle($request->request->get('title'))
        //             ->setContent($request->request->get('content'))
        //             ->setImage($request->request->get('image'))
        //             ->setCreatedAt(new \DateTime());
        //     $manager->persist($article);
        //     //persiste permet de garder en memoire
        //     $manager->flush();  
        //     //flush   
        //     return $this->redirectToRoute('blog_show' , [
        //         'id' =>$article->getId()
        //     ]) ;   
        // }

        //autrement
        // $article = new Article;

        // $form = $this->createFormBuilder($article)
        //              ->add('title', TextType::class, [
        //                  'attr' => [
        //                      'placeholder' => "Titre de l'article",
        //                      'class' => 'form-control mb-3'
        //                  ]
        //              ])

        //              ->add('content', TextareaType::class, [
        //                  'attr' => [
        //                       'placeholder' => "contenu de l'article",
        //                       'class' => 'form-control mb-3'
        //                  ]
        //              ])
        //              ->add('image', TextType::class, [
        //                 'attr' => [
        //                     'placeholder' => "url de l'image",
        //                     'class' => 'form-control mb-3'
        //                 ]
        //              ])
        //              ->add('save', SubmitType::class, [
        //                 'label' => 'Enregistrer'   
                        
        //              ])
        //              ->getForm();

        //autrement

        /*
        createformulaire est une metode predefini de symfony qui permet de creer un formulaire a partir d'une entite dans notre 
        cas de la classe article , cela permet aussi de dire que le formulaire permettra de remplir
        Article $article
        add() est une methode qui permet de creer les diffrernts champ du formulaire
        getform() est une methode qui permet de terminer et de valider le formulaire
        
        handlerequest est une methode qui permet de recuperer dans notre les info stockee dans l'objet $article
        plus besoin de faire appel aux setters de la class article
        */

        //si l'objet $article n'est pas rempli , cela veut dire que nous n'avons pas envoyer d'{id}dans l'url, alors cest une insertion , on creer un nvel 
        //des champs du formulaire
        if(!$article)
        {
        $article = new Article;
           
        }

        // $article->setTitle("Titre à la con")
        //          ->setContent("contenu de l'article");
        // //on construit le formulaire
        // $form = $this->createFormBuilder($article)
        //              ->add('title')

        //              ->add('content')

        //              ->add('image')
                     
        //              ->getForm();

        /* permet de faire appela la class articletype permettent de generer le formulaire d'ajout/modification
          on precise que ce formulaire permettra de remplir un objet issue de la classe article $article */
    $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        //soumission du formulaire
        if($form->isSubmitted() && $form->isValid())
        {
            
            //si l'article ne possede pas {id}, cela veut dire que que ce nest pas une modif,alors on appel le setteur
           // date creation de l'article
            if(!$article->getId())
            {

               $article->setCreatedAt(new \DateTime());
              
            }
            $manager->persist($article);//persist recupere l'objet $article de prepare la requete d'insertion
            $manager->flush();//flush libere reelement la requete sql d'insertion

            //on redirige apres l'insertion vers le details de l'article que nous venons d'inserer
            return $this->redirectToRoute('blog_show' , [
                        'id' =>$article->getId()
                    ]) ;   
        }

         //getform permet de valider le formulaire
        return $this->render('blog/create.html.twig',[
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() != null //on test un article qui possede un id ou non , si l'article possede un id c'est une modification , si il n'a pas d'id cest une insertion

        ]);      
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
