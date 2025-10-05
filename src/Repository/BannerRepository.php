<?php

namespace App\Repository;

use App\Entity\Banner;
use App\Entity\EntityInterface;
use App\Model\DataTableModel;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * @method Banner|null find($id, $lockMode = null, $lockVersion = null)
 * @method Banner|null findOneBy(array $criteria, array $orderBy = null)
 * @method Banner[]    findAll()
 * @method Banner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BannerRepository extends ExtendedEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Banner::class);
    }

    /**
     * @return mixed
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countData()
    {
        $query = $this->createQueryBuilder('b')
            ->select('COUNT(b.id) as total')
            ->innerJoin('b.image', 'image')
        ;

        return $query->getQuery()->getSingleScalarResult();
    }

    /**
     * @param DataTableModel $tableModel
     * @param array          $types
     *
     * @return array
     */
    public function getAdminList(DataTableModel $tableModel, array $types): array
    {
        $query = $this->createQueryBuilder('b')
            ->select(
                'b.id as id',
                'b.position as position',
                'b.status as status',
                'b.type as type',
                'image.name'
            )
            ->innerJoin('b.image', 'image')
            ->where('b.type IN (:types)')
            ->setParameter('types', $types)
            ->setFirstResult($tableModel->getOffset())
            ->setMaxResults($tableModel->getLimit())
            ->orderBy($tableModel->getOrderColumn(), $tableModel->getOrderDirection())
        ;

        return $query->getQuery()->getArrayResult();
    }

    public function getActiveOrderByPosition(string $locale)
    {
        $query = $this->createQueryBuilder('b')
            ->select(
                'b.id',
                'b.position',
                'bt.description',
                'bt.buttonLink as button_link',
                'bt.buttonText as button_text',
                'i.name as image'
            )
            ->innerJoin('b.bannerTranslations', 'bt')
            ->innerJoin('b.image', 'i')
            ->where('b.status = :status')
            ->andWhere('bt.locale = :locale')
            ->andWhere('b.type = :speedLinks')
            ->setParameter('status', EntityInterface::STATUS_ACTIVE)
            ->setParameter('locale', $locale)
            ->setParameter('speedLinks', Banner::TYPE_SPEED_LINKS)
            ->orderBy('b.position');

        return $query->getQuery()->getArrayResult();
    }
}
