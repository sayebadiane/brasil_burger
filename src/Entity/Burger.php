<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
class Burger extends Produit
{
   

    #[ORM\ManyToOne(targetEntity: Catalogues::class, inversedBy: 'burgers')]
    private $burger;

    public function getBurger(): ?Catalogues
    {
        return $this->burger;
    }

    public function setBurger(?Catalogues $burger): self
    {
        $this->burger = $burger;

        return $this;
    }
}
