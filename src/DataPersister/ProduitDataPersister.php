<?php

namespace App\DataPersister;

use App\Entity\Menu;
use App\Entity\Produit;
use App\Service\FileUploader;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;

class ProduitDataPersister implements DataPersisterInterface
{
    private EntityManagerInterface $entityManager;
    private RequestStack $requeststack;
    public function __construct(
        EntityManagerInterface $entityManager,
        FileUploader $fileUploader,
        RequestStack $requeststack
    ) {
        $this->entityManager = $entityManager;
        $this->fileUploader = $fileUploader;
        $this->requeststack = $requeststack;
    }
    public function supports($data): bool
    {
        return $data instanceof Produit;
    }
    /**
     * @param Produit $data
     */
    public function persist($data)
    {
        dd("ok");
        $data->setImagefile($this->requeststack->getCurrentRequest()->files->all()["imagefile"]);
        $realPath = $data->getImagefile()->getRealPath();
        $image = stream_get_contents(fopen($realPath, 'rb'));
        $data->setImage($image);
        //dd($data);
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
