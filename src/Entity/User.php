<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "discr", type: "string")]
#[ORM\DiscriminatorMap(["user" => "User", "gestionnaire" => "Gestionnaire", "client"=>"Client", "livreur"=>"Livreur"])]
#[ApiResource(
    collectionOperations: [
        "get" ,
        "post_register" => [
          "method"=>"post",
          'path'=>'/register',
            'normalization_context' => ['groups' => 'user:read:simple']
        ],
        "add"=>[
            'method'=> 'get',
            "path"=> "/email",
            "controller"=> MailerController::class,
        ]
    ]
    

)] 
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]

    #[Groups(["burger:read:all","write","user:read:simple","menu-write","boisson-post","boisson-get", 'boisson-get-simple'])]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(["burger:read:all","user:read:simple",'menu:get:all',"frite:read:all",'get-write',"boisson-get", 'boisson-get-simple'])]
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $login;

    #[Groups(["user:read:simple"])]
    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $token;

    #[ORM\Column(type: 'boolean')]
    private $isverify=false;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $expiredAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->login;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_VISITEUR';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function isIsverify(): ?bool
    {
        return $this->isverify;
    }

    public function setIsverify(bool $isverify): self
    {
        $this->isverify = $isverify;

        return $this;
    }

    public function getExpiredAt(): ?\DateTimeInterface
    {
        return $this->expiredAt;
    }

    public function setExpiredAt(?\DateTimeInterface $expiredAt): self
    {
        $this->expiredAt = $expiredAt;

        return $this;
    }
}
