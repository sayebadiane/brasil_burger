<?php

namespace App\Entity\Dto;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use App\Repository\CataloguesRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;


#[ApiResource(
    
    attributes: ["pagination_enabled" => false],
    collectionOperations:[
        
        "get"=>[
            'normalization_context' => ['groups' => 'catalogue-get']  
        ]
    ]
    
)]

class Catalogues
{
    
    private $id;

    #[ORM\OneToMany(mappedBy: 'catalogues', targetEntity: Burger::class)]
    #[Groups(["catalogue-get"])]
    private $burgers;

    #[ORM\OneToMany(mappedBy: 'catalogues', targetEntity: Menu::class)]
    #[Groups(["catalogue-get"])]
    private $menus;

    
    public function __construct(BurgerRepository $burgerRepository,MenuRepository $menuRepository)
    {
        $this->burgers = ["burgers" => $burgerRepository->findBy(["etat" => "disponible"])];
        $this->menus = ["menus" => $menuRepository->findBy(["etat" => "disponible"])];
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
