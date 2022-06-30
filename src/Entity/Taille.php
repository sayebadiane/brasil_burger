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
    #[Groups(["menu-post", 'get-write',"boisson-post","boisson-get", 'boisson-get-simple', 'menu:get:all'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups('menu:get:all',"taille:read:simple","menu-get",'get-write',"boisson-get",'boisson-get-simple')]
    private $libelle;

    #[ORM\Column(type: 'float')]
    #[Groups('menu:get:all',"taille:read:simple",'get-write',"boisson-get",'boisson-get-simple')]
    private $prix;

    #[ORM\ManyToMany(targetEntity: Boisson::class, mappedBy: 'tailles')]
    private $boissons;

    #[ORM\ManyToOne(targetEntity: Complements::class, inversedBy: 'tailles')]
    private $complement;

    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'tailles')]
    private $menus;

    public function __construct()
    {
        $this->boissons = new ArrayCollection();
        $this->menus = new ArrayCollection();
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

    /**
     * @return Collection<int, Boisson>
     */
    public function getBoissons(): Collection
    {
        return $this->boissons;
    }

    public function addBoisson(Boisson $boisson): self
    {
        if (!$this->boissons->contains($boisson)) {
            $this->boissons[] = $boisson;
            $boisson->addTaille($this);
        }

        return $this;
    }

    public function removeBoisson(Boisson $boisson): self
    {
        if ($this->boissons->removeElement($boisson)) {
            $boisson->removeTaille($this);
        }

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
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->addTaille($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            $menu->removeTaille($this);
        }

        return $this;
    }
}
