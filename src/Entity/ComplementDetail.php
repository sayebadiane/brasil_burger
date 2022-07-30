<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ComplementDetailRepository;
use Doctrine\ORM\Mapping as ORM;

// #[ORM\Entity(repositoryClass: ComplementDetailRepository::class)]
#[ApiResource]
class ComplementDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Complement1::class, inversedBy: 'complementDetails')]
    private $complements;

    #[ORM\ManyToOne(targetEntity: Burger::class, inversedBy: 'complementDetails')]
    private $burgers;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'complementDetails')]
    private $menus;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComplements(): ?Complement1
    {
        return $this->complements;
    }

    public function setComplements(?Complement1 $complements): self
    {
        $this->complements = $complements;

        return $this;
    }

    public function getBurgers(): ?Burger
    {
        return $this->burgers;
    }

    public function setBurgers(?Burger $burgers): self
    {
        $this->burgers = $burgers;

        return $this;
    }

    public function getMenus(): ?Menu
    {
        return $this->menus;
    }

    public function setMenus(?Menu $menus): self
    {
        $this->menus = $menus;

        return $this;
    }
}
