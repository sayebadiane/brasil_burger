<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use PhpParser\ErrorHandler\Collecting;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            'normalization_context' => ['groups' => 'get-write'],


        ],
        "post"=>[
            'denormalization_context' => ['groups' => 'menu-write'],
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "vous n'avvez pas assez a cette ressouce"
        


        ],
       
       
        
    ],
    itemOperations:[
        "put" => [
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "vous n'avvez pas assez a cette ressouce"
        ],
        "get" => [
            'method' => 'get',
            'status' => 200,
            'normalization_context' => ['groups' => 'menu:get:all']
        ],
         "delete"
    ]
    
)]
class Menu extends Produit
{
    #[ORM\ManyToOne(targetEntity: Catalogues::class, inversedBy: 'menus')]
    private $catalogues;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'menus')]
    #[Groups(["menu-write",'menu:get:all'])]
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
