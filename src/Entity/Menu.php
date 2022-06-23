<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu extends Produit
{
    #[ORM\ManyToOne(targetEntity: Catalogues::class, inversedBy: 'menus')]
    private $catalogues;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'menus')]
    private $gestionnaire;

    public function getCatalogues(): ?Catalogues
    {
        return $this->catalogues;
    }

    public function setCatalogues(?Catalogues $catalogues): self
    {
        $this->catalogues = $catalogues;

        return $this;
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
}
