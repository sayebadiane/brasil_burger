<?php

namespace App\DataPersister;

use App\Entity\Burger;
use App\Service\FileUploader;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class BurgerDataPersister implements DataPersisterInterface
{
    private FileUploader $fileUploader;
    private EntityManagerInterface $entityManager;
    public function __construct(
        EntityManagerInterface $entityManager,
        FileUploader $fileUploader
    ) {
        $this->entityManager = $entityManager;
        $this->fileUploader= $fileUploader;
    }
    public function supports($data): bool
    {
        return $data instanceof Burger;
    }
    /**
     * @param Burger $data
     */
    public function persist($data)
    {
       $data->setImage($this->fileUploader->upload($data->getImagefile()));
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
