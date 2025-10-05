<?php

namespace App\Repository;

use App\Entity\Settings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Settings|null find($id, $lockMode = null, $lockVersion = null)
 * @method Settings|null findOneBy(array $criteria, array $orderBy = null)
 * @method Settings[]    findAll()
 * @method Settings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SettingsRepository extends ExtendedEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Settings::class);
    }

    /**
     * @return array
     */
    public function getSettingsForOrderEmail(): array
    {
        $query = $this->createQueryBuilder('s')
            ->select(
                's.slug',
                's.value'
            )
            ->where('s.slug IN (:settingsSlug)')
            ->setParameter('settingsSlug', [
                Settings::FIELD_MAIN_EMAIL,
                Settings::FIELD_TELEPHONE,
                Settings::FIELD_MOBILE_PHONE,
                Settings::FIELD_STREET,
                Settings::FIELD_CITY,
                Settings::FIELD_ZIP_CODE,
                Settings::FIELD_ACCOUNT_NUMBER,
                Settings::FIELD_PIB,
                Settings::FIELD_FREE_SHIPPING,
                Settings::FIELD_SITE_NAME
            ]);

        return $query->getQuery()->getArrayResult();
    }

    /**
     * @return array
     */
    public function getSettingsForContactPage(): array
    {
        $query = $this->createQueryBuilder('s')
            ->select(
                's.slug',
                's.value'
            );

        return $query->getQuery()->getArrayResult();
    }

    /**
     * @return array
     */
    public function getSettingsForUserRegistrationEmail(): array
    {
        $query = $this->createQueryBuilder('s')
            ->select(
                's.slug',
                's.value'
            );

        return $query->getQuery()->getArrayResult();
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\NoResultException
     */
    public function getFreeShipping(): int
    {
        $query = $this->createQueryBuilder('s')
            ->select(
                's.value'
            )
            ->where('s.slug IN (:settingsSlug)')
            ->setParameter('settingsSlug', [Settings::FIELD_FREE_SHIPPING]);

        return (int) $query->getQuery()->getSingleScalarResult();
    }
}
