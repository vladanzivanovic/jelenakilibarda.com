<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use App\Entity\EntityInterface;
use App\Entity\TranslatableInterface;
use Doctrine\Common\Collections\Collection;

trait TranslationTrait
{
    /**
     * @return Collection
     */
    public function getTranslations(): Collection
    {
        return $this->translations;
    }

    public function addTranslation(TranslatableInterface $translatable): self
    {
        if (!$this->translations->contains($translatable)) {
            $this->translations[] = $translatable;
            $translatable->setEntity($this);
        }

        return $this;
    }

    public function removeTranslation(TranslatableInterface $translatable): self
    {
        if ($this->translations->removeElement($translatable)) {
            // set the owning side to null (unless already changed)
            if ($translatable->getEntity() === $this) {
                $translatable->setEntity(null);
            }
        }

        return $this;
    }

    public function getTranslationByLocale(string $locale): ?TranslatableInterface
    {
        $transCollection = $this->translations;

        $filtered = $transCollection->filter(function ($trans) use ($locale) {
            /** @var TranslatableInterface $trans */
            return $trans->getLocale() === $locale;
        });

        return $filtered->first();
    }
}
