<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use App\Repository\PortionFriteRepository;
use App\Repository\BoissonTailleRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ComplementDeatilRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    itemOperations: [

        "get" => [
            'normalization_context' => ['groups' => 'details']
        ]
    ]
)]
class ComplementDeatil
{

    public ?int $id = 1;

    #[Groups(['details'])]
    public ?Menu $menus;
    #[Groups(['details'])]
    public ?Burger $burgers;

    #[Groups(['details'])]
    public array $boissontailles;

    #[Groups(['details'])]
    public array $portionfrites;

    public function __construct()
    {

        // $this->boissontailles= ["boissontaille" => $boissonTailleRepository->findAll()];
        // $this->portionfrites = ["portionfrites" => $portionFriteRepository->findAll()];
        // $this->menus = ["menus" => $menuRepository->findAll()];
        // $this->burgers = ["burgers" => $burgerRepository->findAll()];
    }
}
