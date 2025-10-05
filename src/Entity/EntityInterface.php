<?php

namespace App\Entity;

interface EntityInterface
{
    public const STATUS_PENDING = 1;
    public const STATUS_ACTIVE = 2;
    public const STATUS_ARCHIVED = 3;

    public function getId(): ?int;
}
