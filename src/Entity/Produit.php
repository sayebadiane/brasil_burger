<?php

namespace App\Entity;

use App\Entity\Commande;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[ORM\Entity(repositoryClass: ProduitRepository::class)]

#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "discr", type: "string")]
#[ORM\DiscriminatorMap(["produit" => "Produit", "burger" => "Burger", "menu" => "Menu", "boisson" => "Boisson", "PortionFrite" => "PortionFrite"])]
#[UniqueEntity(
    fields: 'nom',
    message: "le nom du produit doit etre unique"
)]
#[ApiResource()]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups(["burger:read:simple","menu-post"])]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[Groups(["burger:read:simple", "burger:read:all", "write", 'get-write', 'menu:get:all', "frite:read:simple", "frite:read:all", 'menu:read:simple',"menu-post","boisson-post","boisson-get", 'boisson-get-simple'])]
    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Le nom est Obligatoire")]
    protected $nom;

    #[Groups(["burger:read:simple", "burger:read:all", "write", 'get-write', 'menu:get:all', "frite:read:simple", "frite:read:all", 'menu:read:simple',"menu-post","boisson-post","boisson-get", 'boisson-get-simple'])]
    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "L' image est Obligatoire")]

    protected $image;

    #[Groups(["burger:read:simple", "burger:read:all", "write", 'get-write', 'menu:get:all', "frite:read:simple", "frite:read:all", 'menu:read:simple'])]
    #[ORM\Column(type: 'float',nullable:true)]
    // #[Assert\NotBlank(message: "Le prix est Obligatoire")]
    protected $prix;

    #[Groups(["burger:read:all", "write", 'menu:get:all', "frite:read:all", "menu-post","boisson-post","boisson-get"])]
    #[ORM\Column(type: 'string', length: 255)]
    protected $etat;

    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'produits')]
    #[ORM\JoinColumn(nullable: true)]
    private $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->addProduit($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            $commande->removeProduit($this);
        }

        return $this;
    }
}
