<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BoissonTailleCommandeRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BoissonTailleCommandeRepository::class)]
#[ApiResource]
class BoissonTailleCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(['commande-post'])]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: BoissonTaille::class, inversedBy: 'boissonTailleCommandes')]
    #[Groups(['commande-post'])]
    private $boissontaille;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'boissonTailleCommandes')]
    private $commande;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getBoissontaille(): ?BoissonTaille
    {
        return $this->boissontaille;
    }

    public function setBoissontaille(?BoissonTaille $boissontaille): self
    {
        $this->boissontaille = $boissontaille;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }
}
