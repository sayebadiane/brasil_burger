<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BoissonRepository::class)]
#[ApiResource(
    collectionOperations:[
        "post"=>[ 
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "vous n'avvez pas assez a cette ressouce",
            'denormalization_context' => ['groups' => 'boisson-post'],
            'normalization_context' => ['groups' => 'boisson-get']

        ],
        "get"
    ],
    itemOperations:[
        "get" => [
            'normalization_context' => ['groups' => 'boisson-get-simple']


        ],
        "put",
        "delete"
    ]
)]
class Boisson extends Produit
{
    
    
    #[ORM\ManyToMany(targetEntity: Taille::class, inversedBy: 'boissons')]
    #[Groups(["boisson-post",'boisson-get', 'boisson-get-simple'])]
    private $tailles;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'boissons')]
    #[Groups(["boisson-post",'boisson-get', 'boisson-get-simple'])]
    private $gestionnaire;

    public function __construct()
    {
        $this->tailles = new ArrayCollection();
    }

    /**
     * @return Collection<int, Taille>
     */
    public function getTailles(): Collection
    {
        return $this->tailles;
    }

    public function addTaille(Taille $taille): self
    {
        if (!$this->tailles->contains($taille)) {
            $this->tailles[] = $taille;
        }

        return $this;
    }

    public function removeTaille(Taille $taille): self
    {
        $this->tailles->removeElement($taille);

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
