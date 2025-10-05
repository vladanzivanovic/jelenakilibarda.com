<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\Description;
use App\Entity\EntityInterface;

final class BiographyHandler
{
    private BaseSaveHandler $baseSaveHandler;

    private BaseRemoveHandler $baseRemoveHandler;

    public function __construct(
        BaseSaveHandler $baseSaveHandler,
        BaseRemoveHandler $baseRemoveHandler
    ) {
        $this->baseSaveHandler = $baseSaveHandler;
        $this->baseRemoveHandler = $baseRemoveHandler;
    }

    /**
     * @throws \Exception
     */
    public function save(EntityInterface $biography): void
    {
        $this->baseSaveHandler->save($biography, 'SetBiography');
    }

    public function remove(Description $biography): void
    {
        $this->baseRemoveHandler->remove($biography);
    }
}
