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
      $burgers= ($data->getBurgers());
      $prixmenu=0;
    //   $prixburger=0;
    //   $prixportionfrite=0;
    //   $prixtaille=0;
      foreach ($burgers  as $burger) {
         $prixmenu =$prixmenu+ $burger->getPrix();
       
      }
         $portiofrites=$data->getPortionfrites();
      foreach ($portiofrites as $key => $portiofrite) {
            $prixmenu=$prixmenu+ $portiofrite->getPrix();
      }
      $tailles=$data->getTailles();
      foreach ($tailles as $key => $taille) {

            $prixmenu=$prixmenu+$taille->getPrix();
      }

    //    $prixmenu=$prixburger+$prixportionfrite+$prixtaille;
        $data->setPrix($prixmenu);
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
