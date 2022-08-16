<?php
// api/src/DataProvider/BlogPostItemDataProvider.php

namespace App\DataProvider;

use App\Entity\Menu;
use App\Entity\Burger;
use App\Entity\ComplementDeatil;
use App\Repository\ProduitRepository;
use App\Repository\PortionFriteRepository;
use App\Repository\BoissonTailleRepository;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;

final class ComplementDetailDataprovider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    public function __construct(ProduitRepository $repo,BoissonTailleRepository $boissons,PortionFriteRepository $frites)
    {
        $this->repo=$repo;
        $this->boissons=$boissons;
        $this->frites= $frites;
    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return ComplementDeatil::class === $resourceClass;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?ComplementDeatil
    {
        $boissons=$this->boissons->findAll();
        $frites = $this->frites->findAll();
        $produit=$this->repo->findOneBy(['id'=>$id]);
        $complementdetail= new ComplementDeatil();
        $complementdetail->boissontailles=$boissons;
        $complementdetail->portionfrites = $frites;
        if($produit instanceof Burger){
            $complementdetail->burgers = $produit;
        }
        else if ($produit instanceof Menu) {
            $complementdetail->menus = $produit;
        //   $nb= count($produit->getMenuTailles()) ;
            // dd(($produit->getMenuTailles())[0]->getTaille());

        }
        else{
            return null;
        }
        return $complementdetail;
    }
}
