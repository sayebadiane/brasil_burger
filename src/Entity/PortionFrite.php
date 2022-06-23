<?php

namespace App\Entity;

use App\Repository\PortionFriteRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Produit;

#[ORM\Entity(repositoryClass: PortionFriteRepository::class)]
class PortionFrite extends Produit
{
    #[ORM\ManyToOne(targetEntity: Complements::class, inversedBy: 'portionFrites')]
    private $complement;

    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    // #[ORM\Column(type: 'integer')]
    // private $id;

    // public function getId(): ?int
    // {
    //     return $this->id;
    // }

    public function getComplement(): ?Complements
    {
        return $this->complement;
    }

    public function setComplement(?Complements $complement): self
    {
        $this->complement = $complement;

        return $this;
    }
}
