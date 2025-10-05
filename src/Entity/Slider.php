<?php

namespace App\Entity;

use App\Entity\Traits\ResourceTrait;
use App\Entity\Traits\StatusTrait;
use App\Entity\Traits\TranslationTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SliderRepository")
 */
class Slider implements EntityInterface, TranslationInterface, ImageInterface
{
    use ResourceTrait;
    use TranslationTrait;
    use StatusTrait;

    public const POSITION_LEFT = 1;
    public const POSITION_CENTER = 2;
    public const POSITION_RIGHT = 3;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SliderTranslation", mappedBy="entity", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private Collection $translations;

    /**
     * @ORM\OneToMany(targetEntity=SliderHasImages::class, mappedBy="entity", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private Collection $hasImages;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private ?int $textPosition = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $position = null;

    /**
     * @ORM\Column(type="string")
     */
    private ?string $page = null;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
        $this->hasImages = new ArrayCollection();
    }

    public function getTextPosition(): ?int
    {
        return $this->textPosition;
    }

    public function setTextPosition(?int $textPosition): self
    {
        $this->textPosition = $textPosition;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function createTranslation(): TranslatableInterface
    {
        return new SliderTranslation();
    }

    public function getHasImages(): Collection
    {
        return $this->hasImages;
    }

    public function addHasImage(HasImageEntityInterface $hasImageEntity): self
    {
        if (!$this->hasImages->contains($hasImageEntity)) {
            $this->hasImages[] = $hasImageEntity;
            $hasImageEntity->setEntity($this);
        }

        return $this;
    }

    public function removeHasImage(HasImageEntityInterface $hasImageEntity): self
    {
        if ($this->hasImages->removeElement($hasImageEntity)) {
            // set the owning side to null (unless already changed)
            if ($hasImageEntity->getEntity() === $this) {
                $hasImageEntity->setEntity(null);
            }
        }

        return $this;
    }

    public function createHasImage(): SliderHasImages
    {
        return new SliderHasImages();
    }

    public function getPage(): ?string
    {
        return $this->page;
    }

    public function setPage(?string $page): self
    {
        $this->page = $page;

        return $this;
    }
}
