<?php

declare(strict_types=1);

namespace App\Entity;

interface HasImageEntityInterface extends EntityInterface
{
    public function getEntity(): ?EntityInterface;

    public function setEntity(?Description $entity): self;

    public function getImage(): ?Image;

    public function setImage(Image $image): self;
}
