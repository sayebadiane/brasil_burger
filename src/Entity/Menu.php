<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu extends Produit
{
   
    #[ORM\ManyToOne(targetEntity: Catalogues::class, inversedBy: 'menus')]
    private $catalogue;

   

    public function getCatalogue(): ?Catalogues
    {
        return $this->catalogue;
    }

    public function setCatalogue(?Catalogues $catalogue): self
    {
        $this->catalogue = $catalogue;

        return $this;
    }
}
