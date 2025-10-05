<?php

namespace App\Repository;

use App\Entity\VideoTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VideoTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method VideoTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method VideoTranslation[]    findAll()
 * @method VideoTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoTranslationRepository extends ExtendedEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VideoTranslation::class);
    }

    // /**
    //  * @return SliderTranslation[] Returns an array of SliderTranslation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SliderTranslation
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
