<?php

namespace App\Repository;

use App\Entity\StockSite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StockSite>
 *
 * @method StockSite|null find($id, $lockMode = null, $lockVersion = null)
 * @method StockSite|null findOneBy(array $criteria, array $orderBy = null)
 * @method StockSite[]    findAll()
 * @method StockSite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockSiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StockSite::class);
    }

    public function add(StockSite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(StockSite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
