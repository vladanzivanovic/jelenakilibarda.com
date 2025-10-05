<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use App\Entity\EntityInterface;
use Doctrine\ORM\Mapping as ORM;

trait StatusTrait
{
    /**
     * @ORM\Column(type="smallint")
     */
    private int $status = EntityInterface::STATUS_PENDING;

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }
}
