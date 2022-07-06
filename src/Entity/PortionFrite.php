<?php

namespace App\Entity;
use App\Entity\Produit;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PortionFriteRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PortionFriteRepository::class)]
#[ApiResource(
    collectionOperations:
    [
        "post"=>[
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "vous n'avvez pas assez a cette ressouce"
         ],
        "get"=>[
            'method' => 'get',
            'status' => 200,
            'normalization_context' => ['groups' => 'frite:read:simple']
        
        ]
    ],
    itemOperations: [
        "put"=>[
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "vous n'avvez pas assez a cette ressouce"

        ],
        "get"=>[
            'method' => 'get',
            'status' => 200,
            'normalization_context' => ['groups' => 'frite:read:all']

        ]

    ]
)]
class PortionFrite extends Produit
{
    #[ORM\ManyToOne(targetEntity: Complements::class, inversedBy: 'portionFrites')]
    private $complement;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'portionFrites')]
    #[Groups(["frite:read:all"])]
    private $gestionnaire;

    #[ORM\OneToMany(mappedBy: 'portionfrite', targetEntity: MenuPortionFrite::class)]
    private $menuPortionFrites;



   

    public function __construct()
    {
        parent::__construct();
        // $this->menus = new ArrayCollection();
        $this->menuPortionFrites = new ArrayCollection();
    }

    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    // #[ORM\Column(type: 'integer')]
    // private $id;

    // public function getId(): ?int
    // {
    //     return $this->id;
    // }

    public function getComplement(): ?Complements
    {
        return $this->complement;
    }

    public function setComplement(?Complements $complement): self
    {
        $this->complement = $complement;

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

    /**
     * @return Collection<int, MenuPortionFrite>
     */
    public function getMenuPortionFrites(): Collection
    {
        return $this->menuPortionFrites;
    }

    public function addMenuPortionFrite(MenuPortionFrite $menuPortionFrite): self
    {
        if (!$this->menuPortionFrites->contains($menuPortionFrite)) {
            $this->menuPortionFrites[] = $menuPortionFrite;
            $menuPortionFrite->setPortionfrite($this);
        }

        return $this;
    }

    public function removeMenuPortionFrite(MenuPortionFrite $menuPortionFrite): self
    {
        if ($this->menuPortionFrites->removeElement($menuPortionFrite)) {
            // set the owning side to null (unless already changed)
            if ($menuPortionFrite->getPortionfrite() === $this) {
                $menuPortionFrite->setPortionfrite(null);
            }
        }

        return $this;
    }

   

  

    

   
}
