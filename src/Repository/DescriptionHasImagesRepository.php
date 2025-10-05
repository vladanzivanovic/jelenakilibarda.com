<?php

namespace App\Repository;

use App\Entity\DescriptionHasImages;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DescriptionHasImages|null find($id, $lockMode = null, $lockVersion = null)
 * @method DescriptionHasImages|null findOneBy(array $criteria, array $orderBy = null)
 * @method DescriptionHasImages[]    findAll()
 * @method DescriptionHasImages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DescriptionHasImagesRepository extends ExtendedEntityRepository implements HasImageRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DescriptionHasImages::class);
    }

    public function getDescriptionImagesByDescriptionId(int $descriptionId): array
    {
        $query = $this->createQueryBuilder('dhi')
            ->select(
                'i.name as fileName',
            )
            ->innerJoin('dhi.image', 'i')
            ->where('dhi.entity = :descriptionId')
            ->setParameter('descriptionId', $descriptionId);

        return $query->getQuery()->getArrayResult();
    }
}
