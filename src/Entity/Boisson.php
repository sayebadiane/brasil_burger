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
            'input_formats' => [
                'multipart' => ['multipart/form-data'],
            ],
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
    
   

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'boissons')]
    #[Groups(["boisson-post",'boisson-get', 'boisson-get-simple'])]
    private $gestionnaire;

    #[ORM\OneToMany(mappedBy: 'boisson', targetEntity: BoissonTaille::class,cascade:['persist'])]
    #[Groups(["boisson-post"])]
    private $boissonTailles;

    public function __construct()
    {
        $this->boissonTailles = new ArrayCollection();
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

    /**
     * @return Collection<int, BoissonTaille>
     */
    public function getBoissonTailles(): Collection
    {
        return $this->boissonTailles;
    }

    public function addBoissonTaille(BoissonTaille $boissonTaille): self
    {
        if (!$this->boissonTailles->contains($boissonTaille)) {
            $this->boissonTailles[] = $boissonTaille;
            $boissonTaille->setBoisson($this);
        }

        return $this;
    }

    public function removeBoissonTaille(BoissonTaille $boissonTaille): self
    {
        if ($this->boissonTailles->removeElement($boissonTaille)) {
            // set the owning side to null (unless already changed)
            if ($boissonTaille->getBoisson() === $this) {
                $boissonTaille->setBoisson(null);
            }
        }

        return $this;
    }
}
