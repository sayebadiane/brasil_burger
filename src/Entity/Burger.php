<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Response;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            'method'=>'get',
            'status'=> 200,
            'normalization_context'=>['groups'=>'burger:read:simple']

        ],
    "post"=>[
        'denormalization_context' => ['groups' => 'write'],
        'normalization_context' => ['groups' => 'burger:read:all'],
        "security" => "is_granted('ROLE_GESTIONNAIRE')",
        "security_message" => "vous n'avvez pas assez a cette ressouce"
        



    ]],
    itemOperations: [
        "put"=>[
            "security"=>"is_granted('ROLE_GESTIONNAIRE')",
            "security_message"=>"vous n'avvez pas assez a cette ressouce"
        ],
        "get"=> [
            'method' => 'get',
            'status' => 200,
            'normalization_context' => ['groups' => 'burger:read:all']

        ]
    ]
)]
class Burger extends Produit
{
    #[ORM\ManyToOne(targetEntity: Catalogues::class, inversedBy: 'burgers')]
    private $catalogues;
    #[Groups(["burger:read:all", "write"])]
    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'burgers')]
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
