<?php

namespace App\DataPersister;

use App\Entity\Burger;
use App\Service\FileUploader;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\RequestStack;


class BurgerDataPersister implements DataPersisterInterface
{
    private FileUploader $fileUploader;
    private EntityManagerInterface $entityManager;
    public function __construct(
        EntityManagerInterface $entityManager,
        FileUploader $fileUploader,
        RequestStack $reqStack,
    ) {

        $this->entityManager = $entityManager;
        $this->fileUploader = $fileUploader;
        $this->reqStack = $reqStack;
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
        // dd($data);

        $data->setImagefile($this->reqStack->getCurrentRequest()->files->all()["imagefile"]);
        //    dd($this->reqStack->getCurrentRequest()->files->all());
        $realPath = $data->getImagefile()->getRealPath();
        $image = stream_get_contents(fopen($realPath, 'rb'));

        $data->setImage($image);        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
    public function remove($data)
    {
        $data->setEtat("Archiver");
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
}
