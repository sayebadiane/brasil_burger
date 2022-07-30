<?php

    
// api/src/DataProvider/BlogPostCollectionDataProvider.php

namespace App\DataProvider;


use App\Entity\Menu;
use App\Entity\Dto\Catalogues;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use App\Entity\Burger;
use App\Repository\BurgerRepository;
use App\Repository\MenuRepository;

class CatalogueDataprovider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $catalogues;
    public function __construct(BurgerRepository $burgerRepository,MenuRepository $menuRepository)
    {
        $this->catalogues=new Catalogues($burgerRepository,$menuRepository);
    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Catalogues::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        // dd($this->catalogues);

        return [
            $this->catalogues->getBurgers(),
            $this->catalogues->getMenus()
        ];
    }

}

