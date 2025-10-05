<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\EntityInterface;
use App\Helper\ValidatorHelper;
use App\Repository\CurrencyRepository;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

final class CurrencyHandler implements OrmHandlerInterface
{
    private ValidatorHelper $validator;

    private CurrencyRepository $currencyRepository;

    public function __construct(
        ValidatorHelper $validator,
        CurrencyRepository $currencyRepository
    ) {
        $this->validator = $validator;
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    public function save(EntityInterface $entity): void
    {
        $errors = $this->validator->validate($entity, null, "SetCurrency");

        if ($errors->count() > 0) {
            throw new UnprocessableEntityHttpException(json_encode($this->validator->parseErrors($errors)));
        }

        if (is_null($entity->getId())) {
            $this->currencyRepository->persist($entity);
        }

        $this->currencyRepository->flush();
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    public function remove(EntityInterface $entity): void
    {
        $this->currencyRepository->delete($entity);
        $this->currencyRepository->flush();
    }
}