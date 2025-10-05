<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\EntityInterface;
use App\Helper\ValidatorHelper;
use App\Repository\PaymentRepository;
use App\Repository\ShippingRepository;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

final class PaymentHandler implements OrmHandlerInterface
{
    private ValidatorHelper $validator;

    private ShippingRepository $shippingRepository;
    /**
     * @var PaymentRepository
     */
    private PaymentRepository $paymentRepository;

    /**
     * @param ValidatorHelper    $validator
     * @param ShippingRepository $shippingRepository
     * @param PaymentRepository  $paymentRepository
     */
    public function __construct(
        ValidatorHelper $validator,
        ShippingRepository $shippingRepository,
        PaymentRepository $paymentRepository
    ) {
        $this->validator = $validator;
        $this->shippingRepository = $shippingRepository;
        $this->paymentRepository = $paymentRepository;
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
        $errors = $this->validator->validate($entity, null, "SetPayment");

        if ($errors->count() > 0) {
            throw new UnprocessableEntityHttpException(json_encode($this->validator->parseErrors($errors)));
        }

        if (is_null($entity->getId())) {
            $this->paymentRepository->persist($entity);
        }

        $this->paymentRepository->flush();
    }

    /**
     * @param EntityInterface $entity
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function remove(EntityInterface $entity): void
    {
        $this->paymentRepository->delete($entity);
        $this->paymentRepository->flush();
    }
}