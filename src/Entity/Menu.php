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
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[

            'normalization_context' => ['groups' => 'get-write'],
            'security'=>"is_granted('MENU_ALL',_api_resource_class)"
        ],
        "post"=>[
            
            "security_post_denormalize" => "is_granted('AJOUTER_MENU', object)",
            "security_post_denormalize_message"=> "vous n'avez pas le droit d' accées",
                
            "method"=>"post",

            'denormalization_context' => ['groups' => 'menu-post' ],

            'normalization_context' => ['groups' => 'get-write'],
           
        ],
       
       
        
    ],
    itemOperations:[
        "put" => [
            'denormalization_context' => ['groups' => 'menu-post'],
            "access_control" => "is_granted('EDIT', previous_object)",
        ],
        "get" => [
            'method' => 'get',
            'status' => 200,
            'normalization_context' => ['groups' => 'menu:get:all'],
            'security'=> "is_granted('AJOUTER_MENU', object)",
            'security_message'=>" vous n' avez pas accées"
        ],
         "delete"
    ]
    
)]
class Menu extends Produit
{

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'menus')]
    #[Groups(["menu-post", "menu:get:all"])]
    private $gestionnaire;
    // #[ORM\ManyToMany(targetEntity: PortionFrite::class, inversedBy: 'menus')]
    // #[ORM\JoinColumn(nullable: true)]
    // #[Groups(["menu-post","menu:get:all"])]
    // private $portionfrites;
    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuBurger::class,cascade:['persist'])]
    #[Groups(["menu-post",'get-write'])]
    #[Assert\Valid]
    #[Assert\Count(["min" => 1, "minMessage" => "on ne peut pas enregistrer menu sans burger"])]
    private $menuBurgers;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuTaille::class,cascade:['persist'])]
    #[Groups(["menu-post"])]
    #[Assert\Valid]
    private $menuTailles;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuPortionFrite::class,cascade:['persist'])]
    #[Groups(["menu-post"])]
    #[Assert\Valid]
    private $menuPortionFrites;

   

    public function __construct()
    {
        parent::__construct();
        // $this->portionfrites = new ArrayCollection();
        $this->menuBurgers = new ArrayCollection();
        $this->menuTailles = new ArrayCollection();
        $this->menuPortionFrites = new ArrayCollection();
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
            $menuBurger->setMenu($this);
        }
        

        return $this; 
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getMenu() === $this) {
                $menuBurger->setMenu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MenuTaille>
     */
    public function getMenuTailles(): Collection
    {
        return $this->menuTailles;
    }

    public function addMenuTaille(MenuTaille $menuTaille): self
    {
        if (!$this->menuTailles->contains($menuTaille)) {
            $this->menuTailles[] = $menuTaille;
            $menuTaille->setMenu($this);
        }

        return $this;
    }

    public function removeMenuTaille(MenuTaille $menuTaille): self
    {
        if ($this->menuTailles->removeElement($menuTaille)) {
            // set the owning side to null (unless already changed)
            if ($menuTaille->getMenu() === $this) {
                $menuTaille->setMenu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MenuPortionFrite>
     */
    public function getMenuPortionFrites(): Collection
    {
        return $this->menuPortionFrites;
    }

    public function addMenuPortionFrite(MenuPortionFrite $menuPortionFrite): self
    {
        if (!$this->menuPortionFrites->contains($menuPortionFrite)) {
            $this->menuPortionFrites[] = $menuPortionFrite;
            $menuPortionFrite->setMenu($this);
        }

        return $this;
    }

    public function removeMenuPortionFrite(MenuPortionFrite $menuPortionFrite): self
    {
        if ($this->menuPortionFrites->removeElement($menuPortionFrite)) {
            // set the owning side to null (unless already changed)
            if ($menuPortionFrite->getMenu() === $this) {
                $menuPortionFrite->setMenu(null);
            }
        }
       

        return $this;
    }

   

   
}
