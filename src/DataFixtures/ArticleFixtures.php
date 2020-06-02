<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
      //on utilise la bibliotheque faker qui permet d'envoyer des fausses donnees aleatoires dans la bdd
      //on a demande a composer d'installer cette librairie sur notre application

        //creation de 3 categories
        for($i = 1; $i <= 3; $i++)
        {
            //nous avons besoin d'un objet vide afin de renseigner de nouvelle categories
            $category = new Category;
            //on appel les setteurs de l'entrite categoriy
            $category->setTitle($faker->sentence())
                    ->setDescription($faker->paragraph());

            $manager->persist($category);//garde en mémoire

            //creation de 4 a 6 articles
            for($j = 1; $j <= mt_rand(4,6); $j++)
            {
                //nous avons besoin d'un ojet $article vide afin de creer et d'insere de nv article en bdd
                $article = new Article;

                //on demande a faker de crer 5 paragraph aleatoires pour nos nv articles
                $content = '<p>'. join($faker->paragraphs(5), '</p><p>') . '</p>';
            
                //on renseigne les setteurs de l'entrite article grace aux methodes de la library faker (phrase aleatoire (sentence), image aleatoire(imageurl()) etc..)
                
            
                $article->setTitle($faker->sentence())
                         ->setContent($content)
                         ->setImage($faker->imageUrl())
                         ->setCreatedAt($faker->dateTimeBetween('-6 months'))//creation de la date d'article il ya 6 mois a aujourd'hui
                         ->setCategory($category);//relie cette categorie a la table categorie creer juste au dessus
                         //on renseigne la cle etrangere
                $manager->persist($article);


                //creation de 4 a 10 commantaires
               for($k = 1; $k <= mt_rand(4,10); $k++)
               {
                   $comment = new Comment;

                   $content = '<p>'. join($faker->paragraphs(5), '</p><p>') . '</p>';

                   $now = new \DateTime();//objet datetime avec l'heure et de la date du jour
                   $interval = $now->diff($article->getCreatedAt());//represente entre maintenant et la date de creation de l'article
                   $days = $interval->days;
                   $minimum = '-' . $days . 'days';//-100 days entre la date de creation de l'article

                   $comment->setAuthor($faker->name)
                           ->setContent($content)
                           ->setCreatedAt($faker->dateTimeBetween($minimum))
                           ->setArticle($article);//on relie (cle etrangere) nos commentaires aux articles

                   $manager->persist($comment);
                    
                           
               }



            }

     

     }

     $manager->flush();
     //apres executer la commande doctrine pour executer la commande


        //1er code

        // for($i = 1; $i <= 10; $i++) //on boucle 10 fois afin de creer 10 articles
        // {
        //    $article = new Article;//on instancie la classe Article afin de renseigner les propriete private et d'envoyer les objets de type Article

        //    //on renseigne tous les setteurs de la classe Article afin d'ajouter du contenue qui seront inserer dans bdd
        //    $article->setTitle("Titre de mon article n° $i")
        //            ->setContent("<p>contenu de l'article n° $i </p>")
        //            ->setImage("https://picsum.photos/250")
        //            ->setCreatedAt(new \DateTime()); //objet classe dateTime
                   
        //     $manager->persist($article);   //persiste est une methode issue de la classe objet manager qui permet de garder en memoire les objets Article creer , il les fait persister dans le temps

        // }
        

        // $manager->flush();//flush est une methode issue de la classe objetcManager qui permet veritablement de generer linsertion en bdd  



    }
}
