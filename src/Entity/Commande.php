<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use phpDocumentor\Reflection\Types\Nullable;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(
    collectionOperations:[
        "post"=>[
            "security_post_denormalize" => "is_granted('COMMANDE_CREATE', object)",
            "security_post_denormalize_message" => "vous n'avez pas le droit d' accées",
            'denormalization_context' => ['groups' => 'commande-post'],
            'normalization_context' => ['groups' => 'commande-get']  

        ],
        "get"=>[
            'normalization_context' => ['groups' => 'commande-get']  


           

        ]
    ],
    itemOperations:[
        "put",
        "get"
    ]
)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups('commande-get')]
    private $id;
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['commande-get'])]
    private $numeroCommande;
    #[ORM\Column(type: 'datetime')]
    #[Groups(['commande-get'])]
    private $date;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['commande-post', 'commande-get'])]
    private $etat;

    #[ORM\Column(type: 'float')]
    #[Groups(['commande-post', 'commande-get'])]
    private $montant;

    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commandes')]
    private $livraison;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'commandes')]
    private $zone;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'commandes')]
    private $gestionnaire;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    private $client;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: BurgerCommande::class,cascade:['persist'])]
    #[Groups(['commande-post', 'commande-get'])]
    #[Assert\Valid]
    private $burgerCommandes;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: MenuCommande::class,cascade:['persist'])]
    #[Groups(['commande-post', 'commande-get'])]
    #[Assert\Valid]
    private $menuCommandes;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: BoissonTailleCommande::class,cascade:['persist'])]
    #[Groups(['commande-post', 'commande-get'])]
    private $boissonTailleCommandes;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: MenuBoissonTailleCommande::class)]
    private $menuBoissonTailleCommandes;

   
    // #[ORM\ManyToMany(targetEntity: Produit::class, inversedBy: 'commandes')]
    // private $produits;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
        $this->burgerCommandes = new ArrayCollection();
        $this->menuCommandes = new ArrayCollection();
        $this->commandeMenus = new ArrayCollection();
        $this->boissonTailleCommandes = new ArrayCollection();
        $this->menuBoissonTailleCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCommande(): ?string
    {
        return $this->numeroCommande;
    }

    public function setNumeroCommande(string $numeroCommande): self
    {
        $this->numeroCommande = $numeroCommande;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

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

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    // /**
    //  * @return Collection<int, Produit>
    //  */
    // public function getProduits(): Collection
    // {
    //     return $this->produits;
    // }

    // public function addProduit(Produit $produit): self
    // {
    //     if (!$this->produits->contains($produit)) {
    //         $this->produits[] = $produit;
    //     }

    //     return $this;
    // }

    // public function removeProduit(Produit $produit): self
    // {
    //     $this->produits->removeElement($produit);

    //     return $this;
    // }

    /**
     * @return Collection<int, BurgerCommande>
     */
    public function getBurgerCommandes(): Collection
    {
        return $this->burgerCommandes;
    }

    public function addBurgerCommande(BurgerCommande $burgerCommande): self
    {
        if (!$this->burgerCommandes->contains($burgerCommande)) {
            $this->burgerCommandes[] = $burgerCommande;
            $burgerCommande->setCommande($this);
        }

        return $this;
    }

    public function removeBurgerCommande(BurgerCommande $burgerCommande): self
    {
        if ($this->burgerCommandes->removeElement($burgerCommande)) {
            // set the owning side to null (unless already changed)
            if ($burgerCommande->getCommande() === $this) {
                $burgerCommande->setCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MenuCommande>
     */
    public function getMenuCommandes(): Collection
    {
        return $this->menuCommandes;
    }

    public function addMenuCommande(MenuCommande $menuCommande): self
    {
        if (!$this->menuCommandes->contains($menuCommande)) {
            $this->menuCommandes[] = $menuCommande;
            $menuCommande->setCommande($this);
        }

        return $this;
    }

    public function removeMenuCommande(MenuCommande $menuCommande): self
    {
        if ($this->menuCommandes->removeElement($menuCommande)) {
            // set the owning side to null (unless already changed)
            if ($menuCommande->getCommande() === $this) {
                $menuCommande->setCommande(null);
            }
        }

        return $this;
    }
    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, $payload)
    {
        $menuCommande = count($this->getMenuCommandes());
        $burgerCommande = count($this->getBurgerCommandes());

        if ($menuCommande  == 0 && $burgerCommande  == 0) {
            $context
                ->buildViolation('une commande doit avoir obligatoirement un burger ou un menu ')
                ->addViolation();
        }
       
    }

    /**
     * @return Collection<int, BoissonTailleCommande>
     */
    public function getBoissonTailleCommandes(): Collection
    {
        return $this->boissonTailleCommandes;
    }

    public function addBoissonTailleCommande(BoissonTailleCommande $boissonTailleCommande): self
    {
        if (!$this->boissonTailleCommandes->contains($boissonTailleCommande)) {
            $this->boissonTailleCommandes[] = $boissonTailleCommande;
            $boissonTailleCommande->setCommande($this);
        }

        return $this;
    }

    public function removeBoissonTailleCommande(BoissonTailleCommande $boissonTailleCommande): self
    {
        if ($this->boissonTailleCommandes->removeElement($boissonTailleCommande)) {
            // set the owning side to null (unless already changed)
            if ($boissonTailleCommande->getCommande() === $this) {
                $boissonTailleCommande->setCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MenuBoissonTailleCommande>
     */
    public function getMenuBoissonTailleCommandes(): Collection
    {
        return $this->menuBoissonTailleCommandes;
    }

    public function addMenuBoissonTailleCommande(MenuBoissonTailleCommande $menuBoissonTailleCommande): self
    {
        if (!$this->menuBoissonTailleCommandes->contains($menuBoissonTailleCommande)) {
            $this->menuBoissonTailleCommandes[] = $menuBoissonTailleCommande;
            $menuBoissonTailleCommande->setCommande($this);
        }

        return $this;
    }

    public function removeMenuBoissonTailleCommande(MenuBoissonTailleCommande $menuBoissonTailleCommande): self
    {
        if ($this->menuBoissonTailleCommandes->removeElement($menuBoissonTailleCommande)) {
            // set the owning side to null (unless already changed)
            if ($menuBoissonTailleCommande->getCommande() === $this) {
                $menuBoissonTailleCommande->setCommande(null);
            }
        }

        return $this;
    }

    

   

   
}
