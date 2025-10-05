<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\Description;
use App\Entity\EntityInterface;
use App\Entity\Video;

final class VideoEditHandler
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
    public function save(EntityInterface $video): void
    {
        $this->baseSaveHandler->save($video, 'SetVideo');
    }

    public function remove(Video $video): void
    {
        $this->baseRemoveHandler->remove($video);
    }
}
