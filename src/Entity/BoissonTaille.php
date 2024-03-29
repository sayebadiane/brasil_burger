<?php

namespace App\Entity;

use App\Entity\Complement1;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonTailleRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BoissonTailleRepository::class)]
#[ApiResource]
class BoissonTaille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['details','menu:get:all', 'get-write', 'commande-post', 'commande-get', 'complement1-get'])]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(['details','menu:get:all', 'get-write', "boisson-post", 'complement1-get'])]
    #[Assert\Positive()]
    private $stoke = 1;

    #[ORM\ManyToOne(targetEntity: Boisson::class, inversedBy: 'boissonTailles')]
    #[Groups('details','menu:get:all', 'get-write', 'complement1-get', "taille:read:simple", 'complement-get')]
    private $boisson;

    #[ORM\ManyToOne(targetEntity: Taille::class, inversedBy: 'boissonTailles')]
    // #[Groups(['details',"boisson-post"])]
    private $taille;

    #[ORM\OneToMany(mappedBy: 'boissontaille', targetEntity: BoissonTailleCommande::class)]
    private $boissonTailleCommandes;

    #[ORM\OneToMany(mappedBy: 'tailleboisson', targetEntity: MenuBoissonTailleCommande::class)]
    private $menuBoissonTailleCommandes;

    // #[ORM\OneToMany(mappedBy: 'boissontailles', targetEntity: Complement::class)]
    private $complements;

    // #[ORM\OneToMany(mappedBy: 'boissontailles', targetEntity: ComplementDeatil::class)]
    private $complementDeatils;



    public function __construct()
    {
        $this->boissonTailleCommandes = new ArrayCollection();
        $this->menuBoissonTailleCommandes = new ArrayCollection();
        $this->complements = new ArrayCollection();
        $this->complementDeatils = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStoke(): ?int
    {
        return $this->stoke;
    }

    public function setStoke(int $stoke): self
    {
        $this->stoke = $stoke;

        return $this;
    }

    public function getBoisson(): ?Boisson
    {
        return $this->boisson;
    }

    public function setBoisson(?Boisson $boisson): self
    {
        $this->boisson = $boisson;

        return $this;
    }

    public function getTaille(): ?Taille
    {
        return $this->taille;
    }

    public function setTaille(?Taille $taille): self
    {
        $this->taille = $taille;

        return $this;
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
            $boissonTailleCommande->setBoissontaille($this);
        }

        return $this;
    }

    public function removeBoissonTailleCommande(BoissonTailleCommande $boissonTailleCommande): self
    {
        if ($this->boissonTailleCommandes->removeElement($boissonTailleCommande)) {
            // set the owning side to null (unless already changed)
            if ($boissonTailleCommande->getBoissontaille() === $this) {
                $boissonTailleCommande->setBoissontaille(null);
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
            $menuBoissonTailleCommande->setTailleboisson($this);
        }

        return $this;
    }

    public function removeMenuBoissonTailleCommande(MenuBoissonTailleCommande $menuBoissonTailleCommande): self
    {
        if ($this->menuBoissonTailleCommandes->removeElement($menuBoissonTailleCommande)) {
            // set the owning side to null (unless already changed)
            if ($menuBoissonTailleCommande->getTailleboisson() === $this) {
                $menuBoissonTailleCommande->setTailleboisson(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Complement>
     */
    public function getComplements(): Collection
    {
        return $this->complements;
    }

    // /**
    //  * @return Collection<int, ComplementDeatil>
    //  */
    // public function getComplementDeatils(): Collection
    // {
    //     return $this->complementDeatils;
    // }




}
