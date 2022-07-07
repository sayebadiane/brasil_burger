<?php

namespace App\DataPersister;

use App\Entity\Menu;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Service\ServicePrix\CalculPrixMenu;
use App\Service\ServicePrix\ICalculPrixMenu;

class MenuDataPersister implements DataPersisterInterface
{
    private ICalculPrixMenu $calculPrixMenu;
    private EntityManagerInterface $entityManager;
    public function __construct(
        EntityManagerInterface $entityManager,
        ICalculPrixMenu $calculPrixMenu

    ) {
        $this->entityManager = $entityManager;
        $this->calculPrixMenu = $calculPrixMenu;
    }
    public function supports($data): bool
    {


        return $data instanceof Menu;
    }
    /**
     * @param Menu $data
     */
    public function persist($data)
    {
      
        
        $data->setPrix($this->calculPrixMenu->prixMenu($data));
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
    public function remove($data)
    {
        $data->setEtat("Archiver");
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
}
