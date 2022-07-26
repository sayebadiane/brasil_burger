<?php

namespace App\Repository;

use App\Entity\MenuBoissonTailleCommande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MenuBoissonTailleCommande>
 *
 * @method MenuBoissonTailleCommande|null find($id, $lockMode = null, $lockVersion = null)
 * @method MenuBoissonTailleCommande|null findOneBy(array $criteria, array $orderBy = null)
 * @method MenuBoissonTailleCommande[]    findAll()
 * @method MenuBoissonTailleCommande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenuBoissonTailleCommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MenuBoissonTailleCommande::class);
    }

    public function add(MenuBoissonTailleCommande $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MenuBoissonTailleCommande $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MenuBoissonTailleCommande[] Returns an array of MenuBoissonTailleCommande objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MenuBoissonTailleCommande
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
