<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\EntityInterface;
use App\Entity\Product;
use App\Entity\ProductExtension;
use App\Helper\ValidatorHelper;
use App\Repository\ProductRepository;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Webmozart\Assert\Assert;

final class ProductEditHandler
{
    private ValidatorHelper $validator;

    private ProductRepository $productRepository;

    /**
     * @param ValidatorHelper   $validator
     * @param ProductRepository $productRepository
     */
    public function __construct(
        ValidatorHelper $validator,
        ProductRepository $productRepository
    ) {
        $this->validator = $validator;
        $this->productRepository = $productRepository;
    }

    /**
     * @param EntityInterface $entity
     *
     * @return void
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(EntityInterface $entity): void
    {
        Assert::isInstanceOf($entity, Product::class);

        $errors = $this->validator->validate($entity, null, "SetProduct");

        if ($errors->count() > 0) {
            throw new UnprocessableEntityHttpException(json_encode($this->validator->parseErrors($errors)));
        }

        if (is_null($entity->getId())) {
            $this->productRepository->persist($entity);
        }

        $this->productRepository->flush();
    }

    /**
     * @param ProductExtension $product
     * @param int     $status
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function changeStatus(ProductExtension $product, int $status): void
    {
        $product->setStatus($status);

        $this->productRepository->flush();
    }

    /**
     * @param Product $product
     */
    public function remove(Product $product): void
    {
        $this->productRepository->delete($product);
        $this->productRepository->flush();
    }
}
