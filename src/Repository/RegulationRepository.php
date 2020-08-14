<?php

namespace App\Repository;

use App\Entity\Regulation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Regulation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Regulation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Regulation[]    findAll()
 * @method Regulation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegulationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Regulation::class);
    }

    /**
     * @param string $type
     * @param $status
     * @return array
     */
    public function findOneByTypeAndStatus(string $type, $status): array
    {
        $result =  $this->createQueryBuilder('r')
            ->where('r.type = :type')
            ->andWhere('r.status = :status')
            ->setParameter('type', $type)
            ->setParameter('status', $status)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();

        return $result;
    }
    // /**
    //  * @return Regulation[] Returns an array of Regulation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Regulation
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
