<?php


// api/src/DataProvider/BlogPostCollectionDataProvider.php

namespace App\DataProvider;

use App\Entity\Complement1;
use App\Repository\PortionFriteRepository;
use App\Repository\BoissonTailleRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

class Complement1sDataprovider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $complement;
    public function __construct(BoissonTailleRepository $boissonTailleRepository, PortionFriteRepository $portionFriteRepository)
    {

        $this->complement = new Complement1($boissonTailleRepository, $portionFriteRepository);
    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return complement1::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        // dd($this->catalogues);

        return [
            $this->complement->getBoissonTailles(),
            $this->complement->getPrrtionfrites()
        ];
    }
}
