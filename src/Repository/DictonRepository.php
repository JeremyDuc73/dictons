<?php

namespace App\Repository;

use App\Entity\Dicton;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Dicton>
 *
 * @method Dicton|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dicton|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dicton[]    findAll()
 * @method Dicton[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DictonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dicton::class);
    }

    public function save(Dicton $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Dicton $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Dicton[] Returns an array of Dicton objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    public function countByYear($year): int
    {
        $jan1st = new \DateTime($year.'-01-01');


        $dec31th = new \DateTime($year.'-12-31');


        return count($this->createQueryBuilder('dicton')
            ->andWhere('dicton.createdAt >= :val')
            ->setParameter('val', $jan1st)

            ->andWhere('dicton.createdAt <= :maxval')
            ->setParameter('maxval', $dec31th)
            ->getQuery()
            ->getResult()
        );
    }
}
