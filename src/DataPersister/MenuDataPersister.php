<?php

namespace App\DataPersister;
use App\Entity\Menu;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;

class MenuDataPersister implements DataPersisterInterface
{
    private EntityManagerInterface $entityManager;
    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
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
        // dd($data);
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
