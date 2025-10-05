<?php

namespace App\Repository;

use App\Entity\EntityInterface;
use App\Entity\Image;
use App\Entity\Slider;
use App\Model\DataTableModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * @method Slider|null find($id, $lockMode = null, $lockVersion = null)
 * @method Slider|null findOneBy(array $criteria, array $orderBy = null)
 * @method Slider[]    findAll()
 * @method Slider[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SliderRepository extends ExtendedEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Slider::class);
    }

    /**
     * @return mixed
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countData()
    {
        $query = $this->createQueryBuilder('s')
            ->select('COUNT(s.id) as total')
            ->innerJoin('s.hasImages', 'shi')
            ->innerJoin('shi.image', 'image')
            ->where('image.device = :desktopDevice')
            ->setParameter('desktopDevice', Image::DEVICE_DESKTOP)
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
        $query = $this->createQueryBuilder('s')
            ->select(
                's.id as id',
                's.position as position',
                's.status as status',
                'image.name'
            )
            ->innerJoin('s.hasImages', 'shi')
            ->innerJoin('shi.image', 'image')
            ->where('image.device = :desktopDevice')
            ->setParameter('desktopDevice', Image::DEVICE_DESKTOP)
            ->setFirstResult($tableModel->getOffset())
            ->setMaxResults($tableModel->getLimit())
            ->orderBy($tableModel->getOrderColumn(), $tableModel->getOrderDirection())
        ;

        return $query->getQuery()->getArrayResult();
    }

    /**
     * @return array
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getLastPosition(): array
    {
        $query = $this->createQueryBuilder('s')
            ->select(
                's.position'
            )
            ->orderBy('s.position', 'DESC')
            ->setMaxResults(1);

        return $query->getQuery()->getScalarResult();
    }

    /**
     * @param int $position
     *
     * @return array
     */
    public function getHigherThenPosition(int $position): array
    {
        $query = $this->createQueryBuilder('s')
            ->where('s.position > :position')
            ->setParameter('position', $position);

        return $query->getQuery()->getResult();
    }

    /**
     * @param string $locale
     * @param int    $device
     *
     * @return array|null
     * @throws NonUniqueResultException
     */
    public function getActiveSliderByPage(string $locale, int $device, string $page): ?array
    {
        $query = $this->createQueryBuilder('s')
            ->select(
                's.id',
                's.textPosition as position',
                'st.description',
                'st.buttonText as button_text',
                'st.buttonLink as button_link',
                'i.name as image',
                'i.device'
            )
            ->innerJoin('s.translations', 'st')
            ->innerJoin('s.hasImages', 'shi')
            ->innerJoin('shi.image', 'i')
            ->where('s.status = :activeStatus')
            ->andWhere('st.locale = :locale')
            ->andWhere('i.device = :device')
            ->andWhere('s.page = :page')
            ->setParameter('activeStatus', EntityInterface::STATUS_ACTIVE)
            ->setParameter('locale', $locale)
            ->setParameter('device', $device)
            ->setParameter('page', $page)
            ->setMaxResults(1)
            ->orderBy('s.position');

        return $query->getQuery()->getOneOrNullResult();
    }
}
