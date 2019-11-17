<?php

namespace App\Repository;

use DateTime;
use Exception;
use App\Entity\{Order, User};
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\{AbstractQuery, Query\Expr\Join};

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    /**
     * @param int $interval
     * @param array $weeks - ODBC standard
     * @param int $limit
     * @return mixed
     * @throws Exception
     */
    public function findOrderByPeriod(int $interval,array $weeks = [1,2,3,4,5,6,7], int $limit = 500){
        return $this->createQueryBuilder('o')
            ->select('o.id orderid,u.email,o.date')
            ->join(User::class,'u',Join::WITH,'o.user = u')
            ->where('o.date BETWEEN :start AND NOW()')
            ->andWhere('DAYOFWEEK(o.date) IN (:weeks)')
            ->setParameters([
                'start' => new DateTime('-'.$interval.' days'),
                'weeks' => $weeks
            ])
            ->orderBy('o.date','DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getArrayResult();
    }

    // /**
    //  * @return Order[] Returns an array of Order objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Order
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
