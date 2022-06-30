<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use PhpParser\ErrorHandler\Collecting;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            'normalization_context' => ['groups' => 'get-write'],
        ],
        "post"=>[
            "method"=>"post",
            'denormalization_context' => ['groups' => 'menu-post' ],
            'normalization_context' => ['groups' => 'get-write'],
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "vous n'avvez pas assez a cette ressouce"
        ],
       
       
        
    ],
    itemOperations:[
        "put" => [
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "vous n'avvez pas assez a cette ressouce"
        ],
        "get" => [
            'method' => 'get',
            'status' => 200,
            'normalization_context' => ['groups' => 'menu:get:all']
        ],
         "delete"
    ]
    
)]
class Menu extends Produit
{

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'menus')]
    #[Groups(["menu-post"])]
    private $gestionnaire;

    #[ORM\ManyToMany(targetEntity: Burger::class, inversedBy: 'menus')]
    #[Groups(["menu-post"])]
    private $burgers;

    #[ORM\ManyToMany(targetEntity: PortionFrite::class, inversedBy: 'menus')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(["menu-post","menu:get:all"])]
    private $portionfrites;
    #[ORM\ManyToMany(targetEntity: Taille::class, inversedBy: 'menus')]
    #[ORM\JoinColumn(nullable:true)]
    #[Groups(["menu-post", "menu:get:all"])]
    private $tailles;
    public function __construct()
    {
        parent::__construct();
        $this->burgers = new ArrayCollection();
        $this->portionfrites = new ArrayCollection();
        $this->tailles = new ArrayCollection();
    }

    

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    /**
     * @return Collection<int, Burger>
     */
    public function getBurgers(): Collection
    {
        return $this->burgers;
    }

    public function addBurger(Burger $burger): self
    {
        if (!$this->burgers->contains($burger)) {
            $this->burgers[] = $burger;
        }

        return $this;
    }

    public function removeBurger(Burger $burger): self
    {
        $this->burgers->removeElement($burger);

        return $this;
    }

    /**
     * @return Collection<int, PortionFrite>
     */
    public function getPortionfrites(): Collection
    {
        return $this->portionfrites;
    }

    public function addPortionfrite(PortionFrite $portionfrite): self
    {
        if (!$this->portionfrites->contains($portionfrite)) {
            $this->portionfrites[] = $portionfrite;
        }

        return $this;
    }

    public function removePortionfrite(PortionFrite $portionfrite): self
    {
        $this->portionfrites->removeElement($portionfrite);

        return $this;
    }

    /**
     * @return Collection<int, Taille>
     */
    public function getTailles(): Collection
    {
        return $this->tailles;
    }

    public function addTaille(Taille $taille): self
    {
        if (!$this->tailles->contains($taille)) {
            $this->tailles[] = $taille;
        }

        return $this;
    }

    public function removeTaille(Taille $taille): self
    {
        $this->tailles->removeElement($taille);

        return $this;
    }
}
