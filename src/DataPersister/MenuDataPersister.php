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
         $menuburgers = ($data->getMenuBurgers());
         $prixmenu = 0;
        foreach ($menuburgers  as $menuburger) {
            $prix = $menuburger->getBurger()->getPrix();
            $quantite=$menuburger->getQuantite();
            $prixmenu=$prixmenu+$prix*$quantite;
           
        }  
         $menuportiofrites = $data->getMenuPortionfrites();
           foreach ($menuportiofrites as $key => $menuportiofrite) {
              $prixmenuportion = $menuportiofrite->getPortionfrite()->getPrix();
              $quantite=$menuportiofrite->getQuantity();
              $prixmenu+=$prixmenuportion*$quantite;
            }
        
         $menutailles = $data->getMenuTailles();
           foreach ($menutailles as $key => $menutaille) {
            $prixmenutaille = $menutaille->getTaille()->getPrix();
            $quantite=$menutaille->getQuantity();
            $prixmenu+=$prixmenutaille*$quantite;
        }
         

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
