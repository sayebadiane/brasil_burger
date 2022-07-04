<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BurgerRepository;
use App\Repository\CataloguesRepository;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

// #[ApiResource()]
#[ApiResource(attributes: ["pagination_enabled" => false])]
class Catalogues
{
    
    private $id;

    #[ORM\OneToMany(mappedBy: 'catalogues', targetEntity: Burger::class)]
    private $burgers;

    #[ORM\OneToMany(mappedBy: 'catalogues', targetEntity: Menu::class)]
    private $menus;

    
    public function __construct(BurgerRepository $burgerRepository,MenuRepository $menuRepository)
    {
        $this->burgers = ["burgers"=> $burgerRepository->findBy(["etat" => "disponible"])];
        $this->menus =["menus" => $menuRepository->findBy(["etat" => "disponible"])];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

   
    public function getBurgers()
    {
        return $this->burgers;
    }

    public function getMenus()
    {
        return $this->menus;
    }

   

    


}
