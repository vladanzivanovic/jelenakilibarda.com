<?php

namespace App\Repository;

use App\Entity\Image;
use App\Entity\ImageInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Image|null find($id, $lockMode = null, $lockVersion = null)
 * @method Image|null findOneBy(array $criteria, array $orderBy = null)
 * @method Image[]    findAll()
 * @method Image[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageRepository extends ExtendedEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Image::class);
    }

    public function getByMainEntity(ImageInterface $entity, string $hasImageEntity): array
    {
        $query = $this->createQueryBuilder('i')
            ->select(
                'i.id',
                'i.name as fileName',
                'i.isMain',
                'i.device'
            )
            ->innerJoin($hasImageEntity, 'hie', 'WITH', 'hie.image = i AND hie.entity = :entity')
            ->setParameter('entity', $entity);

        return $query->getQuery()->getArrayResult();
    }

    public function getCatalogImages(?int $maxImages = null): array
    {
        $query = $this->createQueryBuilder('i')
            ->select(
                'i.id',
                'i.name as fileName',
                'i.isMain'
            )
            ->where('i.relatedToType = :relatedType')
            ->setParameter('relatedType', Image::RELATED_TYPE_CATALOG);

        if (null !== $maxImages) {
            $query->setMaxResults($maxImages)
                ->orderBy('i.id', 'DESC');
        }

        return $query->getQuery()->getArrayResult();
    }
}
