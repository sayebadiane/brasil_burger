<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Response;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ApiResource(
    attributes: ["pagination_enabled" => true],
    collectionOperations:[
        "get"=>[
            'method'=>'get',
            'status'=> 200,
            'normalization_context'=>['groups'=>'burger:read:simple']

        ],
    "post"=>[
            'input_formats' => [
                'multipart' => ['multipart/form-data'],
            ],
        "security" => "is_granted('ROLE_GESTIONNAIRE')",
        "security_message" => "vous n'avvez pas assez a cette ressouce",
                'denormalization_context' => ['groups' => 'burger-post'],

        'normalization_context' => ['groups' => 'burger:read:all']
        



    ]],
    itemOperations: [
        "put"=>[
            "security"=>"is_granted('ROLE_GESTIONNAIRE')",
            "security_message"=>"vous n'avvez pas assez a cette ressouce"
        ],
        "get"=> [
            'method' => 'get',
            'status' => 200,
            'normalization_context' => ['groups' => 'burger:read:all']
        ],
        "delete"
    ]
)]
class Burger extends Produit
{
    

    #[Groups(["burger:read:all", "write"])]
    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'burgers')]
    private $gestionnaire;
    #[ORM\OneToMany(mappedBy: 'burger', targetEntity: MenuBurger::class)]
    private $menuBurgers;

    #[ORM\OneToMany(mappedBy: 'burger', targetEntity: BurgerCommande::class)]
    private $burgerCommandes;

    // #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'burgers')]
    // private $menus;

    public function __construct()
    {
        parent::__construct();
        $this->menus = new ArrayCollection();
        $this->menuBurgers = new ArrayCollection();
        $this->burgerCommandes = new ArrayCollection();
    }

    // public function getCatalogues(): ?Catalogues
    // {
    //     return $this->catalogues;
    // }

    // public function setCatalogues(?Catalogues $catalogues): self
    // {
    //     $this->catalogues = $catalogues;

    //     return $this;
    // }

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
     * @return Collection<int, MenuBurger>
     */
    public function getMenuBurgers(): Collection
    {
        return $this->menuBurgers;
    }

    public function addMenuBurger(MenuBurger $menuBurger): self
    {
        if (!$this->menuBurgers->contains($menuBurger)) {
            $this->menuBurgers[] = $menuBurger;
            $menuBurger->setBurger($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getBurger() === $this) {
                $menuBurger->setBurger(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BurgerCommande>
     */
    public function getBurgerCommandes(): Collection
    {
        return $this->burgerCommandes;
    }

    public function addBurgerCommande(BurgerCommande $burgerCommande): self
    {
        if (!$this->burgerCommandes->contains($burgerCommande)) {
            $this->burgerCommandes[] = $burgerCommande;
            $burgerCommande->setBurger($this);
        }

        return $this;
    }

    public function removeBurgerCommande(BurgerCommande $burgerCommande): self
    {
        if ($this->burgerCommandes->removeElement($burgerCommande)) {
            // set the owning side to null (unless already changed)
            if ($burgerCommande->getBurger() === $this) {
                $burgerCommande->setBurger(null);
            }
        }

        return $this;
    }
}
