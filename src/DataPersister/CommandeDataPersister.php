<?php
namespace App\DataPersister;
use App\Entity\Commande;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\Console\Command\Command;

class CommandeDataPersister implements DataPersisterInterface
{
    private EntityManagerInterface $entityManager;
    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
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
        // $data->setNumeroCommande("001");
        // $data->setDate("2020");
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
