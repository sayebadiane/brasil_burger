<?php

namespace App\Entity;

use App\Repository\CataloguesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CataloguesRepository::class)]
class Catalogues
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToMany(mappedBy: 'catalogues', targetEntity: Burger::class)]
    private $burgers;

    

    public function __construct()
    {
        $this->burgers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Burger>
     */
    public function getBurgers(): Collection
    {
        return $this->burgers;
    }

    public function addBurger(Burger $burger): self
    {
        if (!$this->burgers->contains($burger)) {
            $this->burgers[] = $burger;
            $burger->setCatalogues($this);
        }

        return $this;
    }

    public function removeBurger(Burger $burger): self
    {
        if ($this->burgers->removeElement($burger)) {
            // set the owning side to null (unless already changed)
            if ($burger->getCatalogues() === $this) {
                $burger->setCatalogues(null);
            }
        }

        return $this;
    }


}
