<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TailleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TailleRepository::class)]
#[ApiResource(
    collectionOperations:[
        "post"=>[
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "vous n'avvez pas assez a cette ressouce"
        

        ],
        "get"=>[
            'normalization_context' => ['groups' => 'taille:read:simple']


        ]
    ],
    itemOperations:[
        "put",
        "get"=>[

            'normalization_context' => ['groups' => 'menu:get:all']


        ]
    ]
)]
class Taille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["menu-post", 'menu-write','get-write',"boisson-post","boisson-get", 'boisson-get-simple', 'menu:get:all'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups("menu-post", 'menu-write','menu:get:all',"taille:read:simple","menu-get",'get-write',"boisson-get",'boisson-get-simple')]
    private $libelle;

    #[ORM\Column(type: 'float')]
    #[Groups('menu:get:all',"taille:read:simple",'get-write',"boisson-get",'boisson-get-simple')]
    private $prix;

    #[ORM\ManyToOne(targetEntity: Complements::class, inversedBy: 'tailles')]
    private $complement;

    #[ORM\OneToMany(mappedBy: 'taille', targetEntity: MenuTaille::class)]
    private $menuTailles;

    #[ORM\OneToMany(mappedBy: 'taille', targetEntity: BoissonTaille::class)]
    private $boissonTailles;

    // #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'tailles')]
    // private $menus;

    public function __construct()
    {
        // $this->menus = new ArrayCollection();
        $this->menuTailles = new ArrayCollection();
        $this->boissonTailles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
    public function getComplement(): ?Complements
    {
        return $this->complement;
    }

    public function setComplement(?Complements $complement): self
    {
        $this->complement = $complement;

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
            $menuTaille->setTaille($this);
        }

        return $this;
    }

    public function removeMenuTaille(MenuTaille $menuTaille): self
    {
        if ($this->menuTailles->removeElement($menuTaille)) {
            // set the owning side to null (unless already changed)
            if ($menuTaille->getTaille() === $this) {
                $menuTaille->setTaille(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BoissonTaille>
     */
    public function getBoissonTailles(): Collection
    {
        return $this->boissonTailles;
    }

    public function addBoissonTaille(BoissonTaille $boissonTaille): self
    {
        if (!$this->boissonTailles->contains($boissonTaille)) {
            $this->boissonTailles[] = $boissonTaille;
            $boissonTaille->setTaille($this);
        }

        return $this;
    }

    public function removeBoissonTaille(BoissonTaille $boissonTaille): self
    {
        if ($this->boissonTailles->removeElement($boissonTaille)) {
            // set the owning side to null (unless already changed)
            if ($boissonTaille->getTaille() === $this) {
                $boissonTaille->setTaille(null);
            }
        }

        return $this;
    }
}
