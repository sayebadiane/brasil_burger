<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use PhpParser\ErrorHandler\Collecting;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get" => [

            'normalization_context' => ['groups' => 'get-write'],
            'security' => "is_granted('MENU_ALL',_api_resource_class)"
        ],
        "post" => [
            "security_post_denormalize" => "is_granted('AJOUTER_MENU', object)",
            "security_post_denormalize_message" => "vous n'avez pas le droit d' accées",

            "method" => "post",
            'input_formats' => [
                'multipart' => ['multipart/form-data'],
            ],
            'denormalization_context' => ['groups' => 'menu-post'],
            'normalization_context' => ['groups' => 'menu-write'],
        ],



    ],
    itemOperations: [
        "put" => [
            'denormalization_context' => ['groups' => 'menu-post'],
            "access_control" => "is_granted('EDIT', previous_object)",
        ],
        "get" => [
            'method' => 'get',
            'status' => 200,
            'normalization_context' => ['groups' => 'menu:get:all'],
            'security' => "is_granted('AJOUTER_MENU', object)",
            'security_message' => " vous n' avez pas accées"
        ],
        "delete"
    ]

)]
class Menu extends Produit
{

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'menus')]
    #[Groups(["menu:get:all"])]
    private $gestionnaire;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuBurger::class, cascade:['persist'])]
    #[Groups(["menu-post", 'menu-write'])]
    #[Assert\Valid]
    #[Assert\Count(["min" => 1, "minMessage" => "on ne peut pas enregistrer menu sans burger"])]
    private $menuBurgers;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuTaille::class, cascade: ['persist'])]
    #[Groups(["menu-post",'menu-write'])]
    #[Assert\Valid]
    private $menuTailles;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuPortionFrite::class, cascade: ['persist'])]
    #[Groups(["menu-post"])]
    #[Assert\Valid]
    private $menuPortionFrites;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuCommande::class)]
    private $menuCommandes;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuBoissonTailleCommande::class,cascade:['persist'])]
    #[Groups(["menu-post"])]
    private $menuBoissonTailleCommandes;

  

    public function __construct()
    {
        parent::__construct();
        // $this->portionfrites = new ArrayCollection();
        $this->menuBurgers = new ArrayCollection();
        $this->menuTailles = new ArrayCollection();
        $this->menuPortionFrites = new ArrayCollection();
        $this->menuCommandes = new ArrayCollection();
        $this->commandeMenus = new ArrayCollection();
        $this->menuBoissonTailleCommandes = new ArrayCollection();
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


    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, $payload)
    {
        $portion = count($this->getMenuPortionFrites());
        $boison = count($this->getMenuTailles());

        if ($portion == 0 && $boison == 0) {
            $context
                ->buildViolation('on doit avoire obligatoirement une boisson ou une portion de frite dans un menu')
                ->addViolation();
        }
        if ($this->doublon() != true) {
            $context
                ->buildViolation('vous ne pouvais pas choisir deux menu de meme id')
                ->addViolation();
        }
    }
    public  function doublon(): bool
    {
        $i = count($this->getMenuBurgers());

        $tab = [];
        for ($j = 0; $j < $i; $j++) {
            // $tab[$j] = $data->getMenuBurgers()[$j]->getBurger()->getId();
            $tab[$j] = ($this->getMenuBurgers()[$j]->getBurger()->getId());
        }
        $count1 = count(array_unique($tab));

        if ($i != $count1) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @return Collection<int, MenuCommande>
     */
    public function getMenuCommandes(): Collection
    {
        return $this->menuCommandes;
    }

    public function addMenuCommande(MenuCommande $menuCommande): self
    {
        if (!$this->menuCommandes->contains($menuCommande)) {
            $this->menuCommandes[] = $menuCommande;
            $menuCommande->setMenu($this);
        }

        return $this;
    }

    public function removeMenuCommande(MenuCommande $menuCommande): self
    {
        if ($this->menuCommandes->removeElement($menuCommande)) {
            // set the owning side to null (unless already changed)
            if ($menuCommande->getMenu() === $this) {
                $menuCommande->setMenu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MenuBoissonTailleCommande>
     */
    public function getMenuBoissonTailleCommandes(): Collection
    {
        return $this->menuBoissonTailleCommandes;
    }

    public function addMenuBoissonTailleCommande(MenuBoissonTailleCommande $menuBoissonTailleCommande): self
    {
        if (!$this->menuBoissonTailleCommandes->contains($menuBoissonTailleCommande)) {
            $this->menuBoissonTailleCommandes[] = $menuBoissonTailleCommande;
            $menuBoissonTailleCommande->setMenu($this);
        }

        return $this;
    }

    public function removeMenuBoissonTailleCommande(MenuBoissonTailleCommande $menuBoissonTailleCommande): self
    {
        if ($this->menuBoissonTailleCommandes->removeElement($menuBoissonTailleCommande)) {
            // set the owning side to null (unless already changed)
            if ($menuBoissonTailleCommande->getMenu() === $this) {
                $menuBoissonTailleCommande->setMenu(null);
            }
        }

        return $this;
    }

    
    

    
}
