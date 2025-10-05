<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\Collection;

interface ImageInterface
{
    public function getHasImages(): Collection;

    public function addHasImage(HasImageEntityInterface $hasImageEntity): self;

    public function removeHasImage(HasImageEntityInterface $hasImageEntity): self;

    public function createHasImage(): HasImageEntityInterface;
}
