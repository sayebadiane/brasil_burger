<?php

namespace App\Repository;

use App\Entity\ComplementDeatil;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ComplementDeatil>
 *
 * @method ComplementDeatil|null find($id, $lockMode = null, $lockVersion = null)
 * @method ComplementDeatil|null findOneBy(array $criteria, array $orderBy = null)
 * @method ComplementDeatil[]    findAll()
 * @method ComplementDeatil[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComplementDeatilRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComplementDeatil::class);
    }

    public function add(ComplementDeatil $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ComplementDeatil $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ComplementDeatil[] Returns an array of ComplementDeatil objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ComplementDeatil
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
