<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use App\Entity\EntityInterface;
use Doctrine\ORM\Mapping as ORM;

trait TranslatableTrait
{
    /**
     * @ORM\Column(type="string", length=2)
     */
    private string $locale;

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    public function getEntity(): ?EntityInterface
    {
        return $this->entity;
    }

    public function setEntity(?EntityInterface $entity): self
    {
        $this->entity = $entity;

        return $this;
    }
}
