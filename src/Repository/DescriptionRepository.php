<?php

namespace App\Repository;

use App\Entity\Description;
use App\Model\DataTableModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Description|null find($id, $lockMode = null, $lockVersion = null)
 * @method Description|null findOneBy(array $criteria, array $orderBy = null)
 * @method Description[]    findAll()
 * @method Description[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DescriptionRepository extends ExtendedEntityRepository
{
    private string $defaultLocale;

    public function __construct(
        ManagerRegistry $registry,
        string $defaultLocale
    ) {
        parent::__construct($registry, Description::class);
        $this->defaultLocale = $defaultLocale;
    }

    /**
     * @return mixed
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countData()
    {
        $query = $this->createQueryBuilder('d')
            ->select('COUNT(d.id) as total')
            ->innerJoin('d.translations', 'dt')
            ->where('dt.locale = :defaultLocale')
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
        $query = $this->createQueryBuilder('d')
            ->select(
                'd.id as id',
                'd.type as type'
            )
            ->innerJoin('d.translations', 'dt')
            ->where('dt.locale = :defaultLocale')
            ->setParameter('defaultLocale', $this->defaultLocale)
            ->setFirstResult($tableModel->getOffset())
            ->setMaxResults($tableModel->getLimit())
            ->orderBy('d.' . $tableModel->getOrderColumn(), $tableModel->getOrderDirection())
        ;

        return $query->getQuery()->getArrayResult();
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getByType(string $type = Description::TYPE_BIOGRAPHY): ?Description
    {
        $query = $this->createQueryBuilder('b')
            ->orderBy('b.id', 'DESC')
            ->where('b.type = :type')
            ->setParameter('type', $type)
            ->setMaxResults(1);

        return $query->getQuery()->getOneOrNullResult();
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getByLocaleAndType(string $locale, string $type = Description::TYPE_BIOGRAPHY): ?array
    {
        $query = $this->createQueryBuilder('d')
            ->select(
                'd.id',
                'dt.shortDescription as short_description',
                'dt.description',
                'COUNT(dhi.id) as has_images'
            )
            ->innerJoin('d.translations', 'dt')
            ->leftJoin('d.hasImages', 'dhi')
            ->where('dt.locale = :locale')
            ->andWhere('d.type = :type')
            ->setParameter('locale', $locale)
            ->setParameter('type', $type)
            ->orderBy('d.id', 'DESC');

        return $query->getQuery()->getOneOrNullResult();
    }

    // /**
    //  * @return Biography[] Returns an array of Biography objects
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
    public function findOneBySomeField($value): ?Biography
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
