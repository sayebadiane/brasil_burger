<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ZoneRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ZoneRepository::class)]
#[UniqueEntity(fields:'nom',
message:"le nom de la zone doit etre unique")]
#[ApiResource(
    collectionOperations:[
        "get",
        "post"=>[
            "security_post_denormalize" => "is_granted('ZONE_CREATE', object)",
            "security_post_denormalize_message" => "vous n'avez pas le droit d' accées",
                
        ]
    ],
    itemOperations:[
        "get",
        "put",
        "delete"
    ]
)]
class Zone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("quartier-post", "quartier-get")]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups("quartier-get")]
    #[Assert\NotBlank(message: "Le nom est obligatoire")]
    private $nom;

    #[ORM\Column(type: 'float')]
    #[Groups("quartier-get")]
    #[Assert\NotBlank(message: "Le prix est obligatoire")]

    private $prix;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Commande::class)]
    private $commandes;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Quartier::class)]
    private $quarties;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->quarties = new ArrayCollection();
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
            $commande->setZone($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getZone() === $this) {
                $commande->setZone(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Quartier>
     */
    public function getQuarties(): Collection
    {
        return $this->quarties;
    }

    public function addQuarty(Quartier $quarty): self
    {
        if (!$this->quarties->contains($quarty)) {
            $this->quarties[] = $quarty;
            $quarty->setZone($this);
        }

        return $this;
    }

    public function removeQuarty(Quartier $quarty): self
    {
        if ($this->quarties->removeElement($quarty)) {
            // set the owning side to null (unless already changed)
            if ($quarty->getZone() === $this) {
                $quarty->setZone(null);
            }
        }

        return $this;
    }
}
