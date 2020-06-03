<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 * fields = {"email"},
 * message="un compte est deja existant a cette adresse Email!!"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8",minMessage="votre message doit faire minimum 8 caracter")
     * @Assert\EqualTo(propertyPath="confirm_password", message="les mots de passe ne correspondent pas")
     */
    private $password;

    /** 
     * @Assert\EqualTo(propertyPath="password", message="les mots de passe ne correspondent pas")
    */
    public $confirm_password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /*
    pour pouvoir encoder le mdp il faut que notre classe (entite) user implemente de la class user interface
    il faut absolument declarer les methodes getroles , getsalt, erasecredentiels , get username, getpassord
     */

    //cette methode est uniquement destinee a nettoyer les mdp en texte brut eventuellement stocke
    public function eraseCredentials()
    {
        
    }
    //renvoie la chaine de caractere encoder que l'utilisateur a saisi qui a ete utiliser a l'origine pour coder le mdp
    
    public function getSalt()
    {

    }

   // cette methode renvoie un tableau de chaine de caractere ou sont stockes les roles accorder a l'utilisateur
    public function getRoles()
    {
        return ['ROLE_USER'];
    }
}
