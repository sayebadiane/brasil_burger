<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MenuBurgerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: MenuBurgerRepository::class)]
#[ApiResource()]

class MenuBurger
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups('menu-post','menu-write')]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups('menu-post','get-write')]
    #[Assert\Positive()]
    private $quantite=1;
    #[ORM\ManyToOne(targetEntity: Burger::class, inversedBy: 'menuBurgers')]
    // #[Assert\Count(["min" =>1,"minMessage"=>"on ne peut pas enregistrer menu sans burger"])]
    #[Assert\NotBlank(message:"le burger est obligatoire")]
    #[Groups('menu-post','menu-write')]
    private $burger;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuBurgers')]
    // #[Assert\NotBlank(message:"un menu doit avoir obligatoirement un burger")]
    private $menu;
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

    public function getBurger(): ?Burger
    {
        return $this->burger;
    }

    public function setBurger(?Burger $burger): self
    {
        $this->burger = $burger;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;
       

        return $this;
        
    }
}
