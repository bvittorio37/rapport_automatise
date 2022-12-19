<?php

namespace App\Repository;

use App\Entity\Rapport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Rapport>
 *
 * @method Rapport|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rapport|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rapport[]    findAll()
 * @method Rapport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RapportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rapport::class);
    }

    public function add(Rapport $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Rapport $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    /**
    * @return Rapport[] Returns an array of Rapport objects
     */
        public function rechercher($site, $type, $debut , $fin): array
        {
                $qb= $this->createQueryBuilder('r');
            if($type){
                $qb->andWhere('r.typeRapport= :type')
                    ->setParameter('type', $type);
            }
            if($site){
                $qb->andWhere('r.site= :site')
                    ->setParameter('site', $site);
            }
            if($debut){
                $qb->andWhere('r.debutService >= :debut')
                    ->setParameter('debut', $debut);
            }
            if($fin){
                $qb->andWhere('r.debutService <= :debut')
                    ->setParameter('debut', $fin);
            }
                return $qb->getQuery()
                ->getResult() ;
            }
    
//    /**
//     * @return Rapport[] Returns an array of Rapport objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Rapport
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
