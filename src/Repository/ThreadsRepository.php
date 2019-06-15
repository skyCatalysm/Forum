<?php

namespace App\Repository;

use App\Entity\Threads;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Threads|null find($id, $lockMode = null, $lockVersion = null)
 * @method Threads|null findOneBy(array $criteria, array $orderBy = null)
 * @method Threads[]    findAll()
 * @method Threads[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThreadsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Threads::class);
    }

    // /**
    //  * @return Threads[] Returns an array of Threads objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Threads
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
