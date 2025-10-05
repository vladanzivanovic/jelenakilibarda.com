<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\EntityInterface;
use App\Helper\ValidatorHelper;
use App\Repository\ShippingRepository;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

final class ShippingHandler implements OrmHandlerInterface
{
    private ValidatorHelper $validator;

    private ShippingRepository $shippingRepository;

    /**
     * @param ValidatorHelper    $validator
     * @param ShippingRepository $shippingRepository
     */
    public function __construct(
        ValidatorHelper $validator,
        ShippingRepository $shippingRepository
    ) {
        $this->validator = $validator;
        $this->shippingRepository = $shippingRepository;
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
        $errors = $this->validator->validate($entity, null, "SetShipping");

        if ($errors->count() > 0) {
            throw new UnprocessableEntityHttpException(json_encode($this->validator->parseErrors($errors)));
        }

        if (is_null($entity->getId())) {
            $this->shippingRepository->persist($entity);
        }

        $this->shippingRepository->flush();
    }

    /**
     * @param EntityInterface $entity
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function remove(EntityInterface $entity): void
    {
        $this->shippingRepository->delete($entity);
        $this->shippingRepository->flush();
    }
}