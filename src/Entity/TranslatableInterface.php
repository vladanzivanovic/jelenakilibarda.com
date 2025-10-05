<?php

declare(strict_types=1);

namespace App\Entity;

interface TranslatableInterface
{
    public function getEntity(): ?EntityInterface;

    public function setEntity(?EntityInterface $entity): self;

    public function getLocale(): ?string;

    public function setLocale(string $locale): TranslatableInterface;
}
