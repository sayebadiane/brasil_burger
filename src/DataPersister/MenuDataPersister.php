<?php

namespace App\DataPersister;

use App\Entity\Menu;
use App\Service\FileUploader;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\ServicePrix\CalculPrixMenu;
use App\Service\ServicePrix\ICalculPrixMenu;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuDataPersister implements DataPersisterInterface
{
    private ICalculPrixMenu $calculPrixMenu;
    private EntityManagerInterface $entityManager;
    private RequestStack $reqStack;
    public function __construct(
        EntityManagerInterface $entityManager,
        ICalculPrixMenu $calculPrixMenu,
        FileUploader $fileUploader,
        RequestStack $reqStack,) {

        $this->entityManager = $entityManager;
        $this->calculPrixMenu = $calculPrixMenu;
        $this->fileUploader = $fileUploader;
        $this->reqStack = $reqStack;

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
        $data->setImagefile($this->reqStack->getCurrentRequest()->files->all()["imagefile"]);
    //    dd($this->reqStack->getCurrentRequest()->files->all());
        $realPath = $data->getImagefile()->getRealPath();
        $image = stream_get_contents(fopen($realPath,'rb'));

        $data->setPrix($this->calculPrixMenu->prixMenu($data));
        $data->setImage($image);
        //dd($data);
        $this->entityManager->persist($data);
        $this->entityManager->flush();
        
        // dd($data->getImagefile());
    }
    public function remove($data)
    {
        $data->setEtat("Archiver");
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
}
