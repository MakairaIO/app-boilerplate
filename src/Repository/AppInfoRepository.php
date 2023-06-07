<?php

namespace App\Repository;

use App\Entity\AppInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AppInfo>
 *
 * @method AppInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppInfo[]    findAll()
 * @method AppInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppInfo::class);
    }

    public function save(AppInfo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AppInfo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AppInfo[] Returns an array of AppInfo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

   public function findOneByDomainAndInstance(string $domain, string $instance): ?AppInfo
   {
       return $this->createQueryBuilder('a')
           ->andWhere('a.makairaDomain = :val1')
           ->andWhere('a.makairaInstance = :val2')
           ->setParameter('val1', $domain)
           ->setParameter('val2', $instance)
           ->getQuery()
           ->getOneOrNullResult()
       ;
   }
}
