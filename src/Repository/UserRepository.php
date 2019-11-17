<?php

namespace App\Repository;

use App\Entity\Order;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Expr\Join;
use Exception;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @return mixed
     * @throws NonUniqueResultException
     */
    public function findOneRandom()
    {
        $random_id = $this->getRandId();

        return $this->createQueryBuilder('u')
            ->where('u.id = :random_id')
            ->setParameter('random_id', $random_id)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return int
     * @throws NonUniqueResultException
     */
    public function getRandId(){
        $id_limits = $this->createQueryBuilder('u')
            ->select('MIN(u.id)', 'MAX(u.id)')
            ->getQuery()
            ->getOneOrNullResult();
        return rand($id_limits[1], $id_limits[2]);
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function getTopUserForTotal(int $limit = 500){
        return $this->createQueryBuilder('u')
            ->select('u, SUM(o.total) AS total')
            ->join(Order::class,'o',Join::WITH,'u = o.user')
            ->where('o.status = :status')
            ->setParameter('status',Order::$success)
            ->groupBy('o.user')
            ->orderBy('total','DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * @param $last_year
     * @param int $limit
     * @return mixed
     * @throws Exception
     */
    public function getUserNotSuccessOrder($last_year,int $limit = 500){
        return $this->createQueryBuilder('u')
            ->select('u')
            ->join(Order::class,'o',Join::WITH,'u = o.user')
            ->where('o.date BETWEEN :start AND :end')
            ->andWhere('o.status <> :status')
            ->setParameters([
                'status' => Order::$success,
                'start' => new DateTime("$last_year-01-01"),
                'end' => new DateTime("$last_year-12-31")
            ])
            ->groupBy('o.user')
            ->orderBy('u.registration_date')
            ->setMaxResults($limit)
            ->getQuery()
            ->getArrayResult();
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
