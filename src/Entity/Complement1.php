<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\Complement1Repository;
use App\Repository\PortionFriteRepository;
use App\Repository\BoissonTailleRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    collectionOperations: [
        
        "get"=>[
            'normalization_context' => ['groups' => 'complement1-get']


        ]
    ],
)]
class Complement1
{
    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: BoissonTaille::class, inversedBy: 'complement1s')]
    #[Groups('complement1-get')]
    private $boissonTailles;

    #[ORM\ManyToOne(targetEntity: PortionFrite::class, inversedBy: 'complement1s')]
    #[Groups('complement1-get')]
    private $prrtionfrites;

    // #[ORM\OneToMany(mappedBy: 'complements', targetEntity: ComplementDetail::class)]
    private $complementDetails;

    public function __construct(BoissonTailleRepository $boissonTailleRepository, PortionFriteRepository $portionFriteRepository)
    {


        $this->boissonTailles = ["boissonTailles" => $boissonTailleRepository->findAll()];
        $this->prrtionfrites = ["portionfrites" => $portionFriteRepository->findAll()];
    }





    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBoissonTailles()
    {
        return $this->boissonTailles;
    }

  

    public function getPrrtionfrites()
    {
        return $this->prrtionfrites;
    }
    public function getComplement1(){
        return $this->complement1;
    }

    /**
     * @return Collection<int, ComplementDetail>
     */
    public function getComplementDetails(): Collection
    {
        return $this->complementDetails;
    }

    // public function addComplementDetail(ComplementDetail $complementDetail): self
    // {
    //     if (!$this->complementDetails->contains($complementDetail)) {
    //         $this->complementDetails[] = $complementDetail;
    //         $complementDetail->setComplements($this);
    //     }

    //     return $this;
    // }

    // public function removeComplementDetail(ComplementDetail $complementDetail): self
    // {
    //     if ($this->complementDetails->removeElement($complementDetail)) {
    //         // set the owning side to null (unless already changed)
    //         if ($complementDetail->getComplements() === $this) {
    //             $complementDetail->setComplements(null);
    //         }
    //     }

    //     return $this;
    // }

   
}
