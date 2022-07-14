<?php
namespace App\DataPersister;
use DateTime;
use App\Entity\Commande;
use App\Service\NumeroCommande;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;

class CommandeDataPersister implements DataPersisterInterface
{
    private EntityManagerInterface $entityManager;
    private NumeroCommande $numerocommande;
    public function __construct(
        EntityManagerInterface $entityManager,
        NumeroCommande $numerocommande
    ) {
        $this->entityManager = $entityManager;
        $this->numerocommande= $numerocommande;
    }
    public function supports($data): bool
    {
        
        return $data instanceof Commande;
    }
    /**
     * @param Commande $data
     */
    public function persist($data)
    {
        $data->setNumeroCommande($this->numerocommande->uniqidReal());
        $data->setDate(new DateTime());
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
    public function remove($data)
    {
        // $data->setEtat("Archiver");
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
}
