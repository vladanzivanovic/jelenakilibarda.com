<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\EntityInterface;
use App\Helper\ValidatorHelper;
use App\Repository\CountryRepository;
use App\Repository\ShippingRepository;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

final class CountryHandler implements OrmHandlerInterface
{
    private ValidatorHelper $validator;

    private CountryRepository $countryRepository;

    /**
     * @param ValidatorHelper   $validator
     * @param CountryRepository $countryRepository
     */
    public function __construct(
        ValidatorHelper $validator,
        CountryRepository $countryRepository
    ) {
        $this->validator = $validator;
        $this->countryRepository = $countryRepository;
    }

    /**
     * @param EntityInterface $entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function save(EntityInterface $entity): void
    {
        $errors = $this->validator->validate($entity, null, "SetCountry");

        if ($errors->count() > 0) {
            throw new UnprocessableEntityHttpException(json_encode($this->validator->parseErrors($errors)));
        }

        if (is_null($entity->getId())) {
            $this->countryRepository->persist($entity);
        }

        $this->countryRepository->flush();
    }

    /**
     * @param EntityInterface $entity
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function remove(EntityInterface $entity): void
    {
        $this->countryRepository->delete($entity);
        $this->countryRepository->flush();
    }
}