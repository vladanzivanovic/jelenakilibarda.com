<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\EntityInterface;
use App\Helper\ValidatorHelper;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class BaseSaveHandler
{
    private ValidatorHelper $validator;

    private ObjectManager $objectManager;

    public function __construct(
        ValidatorHelper $validator,
        ObjectManager $objectManager
    ) {
        $this->validator = $validator;
        $this->objectManager = $objectManager;
    }

    /**
     * @throws \Exception
     */
    public function save(EntityInterface $entity, string $validationGroup): void
    {
        $errors = $this->validator->validate($entity, null, $validationGroup);

        if ($errors->count() > 0) {
            throw new UnprocessableEntityHttpException(json_encode($this->validator->parseErrors($errors)));
        }

        if (null === $entity->getId()) {
            $this->objectManager->persist($entity);
        }

        $this->objectManager->flush();
    }
}
