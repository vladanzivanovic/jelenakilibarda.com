<?php

namespace App\Repository;

use App\Entity\DescriptionHasImages;
use App\Entity\SliderHasImages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DescriptionHasImages|null find($id, $lockMode = null, $lockVersion = null)
 * @method DescriptionHasImages|null findOneBy(array $criteria, array $orderBy = null)
 * @method DescriptionHasImages[]    findAll()
 * @method DescriptionHasImages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SliderHasImagesRepository extends ExtendedEntityRepository implements HasImageRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SliderHasImages::class);
    }

    // /**
    //  * @return BiographyHasImages[] Returns an array of BiographyHasImages objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BiographyHasImages
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
