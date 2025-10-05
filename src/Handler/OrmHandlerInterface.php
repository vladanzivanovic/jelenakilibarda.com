<?php

namespace App\Handler;

use App\Entity\EntityInterface;
use App\Entity\ProductSize;

interface OrmHandlerInterface
{
    /**
     * @param EntityInterface $entity
     *
     * @return void
     */
    public function save(EntityInterface $entity): void;

    /**
     * @param EntityInterface $entity
     *
     * @return void
     */
    public function remove(EntityInterface $entity): void;
}