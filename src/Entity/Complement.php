<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BoissonTailleRepository;
use App\Repository\ComplementRepository;
use App\Repository\PortionFriteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

// #[ORM\Entity(repositoryClass: ComplementRepository::class)]
#[ApiResource(
    collectionOperations: [

        "get" => [
            'normalization_context' => ['groups' => 'complement-get']
        ]
    ]

)]
class Complement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: BoissonTaille::class, inversedBy: 'complements')]
    #[Groups("complement-get")]
    private $boissontailles;

    #[ORM\ManyToOne(targetEntity: PortionFrite::class, inversedBy: 'complements')]
    #[Groups("complement-get")]
    private $portionfrites;

    public function __construct(BoissonTailleRepository $boissonTailleRepository,PortionFriteRepository $portionFriteRepository)
    {

      
         $this->boissonTailles = ["boissonTailles" => $boissonTailleRepository->findAll()];
         $this->portionfrites = ["portionfrites" => $portionFriteRepository->findAll()];
    }
     

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBoissontailles()
    {
        return $this->boissontailles;
    }

    public function getPortionfrites()
    {
        return $this->portionfrites;
    }

   
}
