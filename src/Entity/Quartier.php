<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\QuartierRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: QuartierRepository::class)]
#[UniqueEntity(
    fields: 'libelle',
    message: "le libelle de la quartier doit etre unique"
)]
#[ApiResource(collectionOperations:
["post"=>[
        "security" => "is_granted('ROLE_GESTIONNAIRE')",
        "security_message" => "vous n'avvez pas assez a cette ressouce",
        "method" => "post",
        'denormalization_context' => ['groups' => 'quartier-post'],
        'normalization_context' => ['groups' => 'quartier-get']
        
    ],
"get"
],
itemOperations:[
    "get",
    "put",
    "delete"

]
)]
class Quartier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups("quartier-post", "quartier-get")]
    #[Assert\NotBlank(message: "Le libelle est obligatoire")]

    private $libelle;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'quarties')]
    #[Groups("quartier-post","quartier-get")]
    private $zone;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }
}
