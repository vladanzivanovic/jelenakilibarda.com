<?php

namespace App\Repository;

use App\Entity\EntityInterface;
use App\Entity\Image;
use App\Entity\Video;
use App\Model\DataTableModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Video|null find($id, $lockMode = null, $lockVersion = null)
 * @method Video|null findOneBy(array $criteria, array $orderBy = null)
 * @method Video[]    findAll()
 * @method Video[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoRepository extends ServiceEntityRepository
{
    private string $defaultLocale;

    public function __construct(
        ManagerRegistry $registry,
        string $defaultLocale
    ) {
        parent::__construct($registry, Video::class);
        $this->defaultLocale = $defaultLocale;
    }

    /**
     * @return mixed
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countData()
    {
        $query = $this->createQueryBuilder('v')
            ->select('COUNT(v.id) as total')
            ->innerJoin('v.translations', 'vt')
            ->where('vt.locale = :defaultLocale')
            ->setParameter('defaultLocale', $this->defaultLocale)
        ;

        return $query->getQuery()->getSingleScalarResult();
    }

    /**
     * @param DataTableModel $tableModel
     *
     * @return array
     */
    public function getAdminList(DataTableModel $tableModel): array
    {
        $query = $this->createQueryBuilder('v')
            ->select(
                'v.id as id',
                'v.status as status',
                'vt.title as title',
                'v.thumbnails as thumbnails'
            )
            ->innerJoin('v.translations', 'vt')
            ->where('vt.locale = :defaultLocale')
            ->setParameter('defaultLocale', $this->defaultLocale)
            ->setFirstResult($tableModel->getOffset())
            ->setMaxResults($tableModel->getLimit())
            ->orderBy($tableModel->getOrderColumn(), $tableModel->getOrderDirection())
        ;

        return $query->getQuery()->getArrayResult();
    }

    public function getVideos(string $locale, ?int $maxItems = null): array
    {
        $query = $this->createQueryBuilder('v')
            ->select(
                'v.id',
                'vt.title',
                'vt.description',
                'v.thumbnails',
                'v.youtubeId'
            )
            ->innerJoin('v.translations', 'vt')
            ->where('vt.locale = :locale')
            ->andWhere('v.status = :status')
            ->setParameter('locale', $locale)
            ->setParameter('status', EntityInterface::STATUS_ACTIVE);

        if (null !== $maxItems) {
            $query->setMaxResults($maxItems);
        }

        return $query->getQuery()->getResult();
    }
}
