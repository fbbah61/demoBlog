<?php

namespace App\DataFixtures;

use App\Entity\Article;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        for($i = 1; $i <= 10; $i++) //on boucle 10 fois afin de creer 10 articles
        {
           $article = new Article;//on instancie la classe Article afin de renseigner les propriete private et d'envoyer les objets de type Article

           //on renseigne tous les setteurs de la classe Article afin d'ajouter du contenue qui seront inserer dans bdd
           $article->setTitle("Titre de mon article n° $i")
                   ->setContent("<p>contenu de l'article n° $i </p>")
                   ->setImage("https://picsum.photos/250")
                   ->setCreatedAt(new \DateTime()); //objet classe dateTime
                   
            $manager->persist($article);   //persiste est une methode issue de la classe objet manager qui permet de garder en memoire les objets Article creer , il les fait persister dans le temps

        }
        

        $manager->flush();//flush est une methode issue de la classe objetcManager qui permet veritablement de generer linsertion en bdd  

    }
}
