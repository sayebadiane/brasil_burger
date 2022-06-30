<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Response;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            'method'=>'get',
            'status'=> 200,
            'normalization_context'=>['groups'=>'burger:read:simple']

        ],
    "post"=>[
        "security" => "is_granted('ROLE_GESTIONNAIRE')",
        "security_message" => "vous n'avvez pas assez a cette ressouce",
        'normalization_context' => ['groups' => 'burger:read:all']
        



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
        ],
        "delete"
    ]
)]
class Burger extends Produit
{
    

    #[Groups(["burger:read:all", "write"])]
    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'burgers')]
    private $gestionnaire;

    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'burgers')]
    private $menus;

    public function __construct()
    {
        parent::__construct();
        $this->menus = new ArrayCollection();
    }

    // public function getCatalogues(): ?Catalogues
    // {
    //     return $this->catalogues;
    // }

    // public function setCatalogues(?Catalogues $catalogues): self
    // {
    //     $this->catalogues = $catalogues;

    //     return $this;
    // }

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
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->addBurger($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            $menu->removeBurger($this);
        }

        return $this;
    }
}
