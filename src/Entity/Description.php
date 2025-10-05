<?php

namespace App\Entity;

use App\Entity\Traits\ResourceTrait;
use App\Entity\Traits\TranslationTrait;
use App\Repository\DescriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DescriptionRepository::class)
 */
class Description implements EntityInterface, TranslationInterface, ImageInterface
{
    use ResourceTrait;
    use TranslationTrait;

    const TYPE_BIOGRAPHY = 'biography';
    const TYPE_REPERTOIRE = 'repertoire';
    const TYPE_PIANO_DUO = 'piano_duo';

    /**
     * @ORM\OneToMany(targetEntity=DescriptionHasImages::class, mappedBy="entity", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private Collection $hasImages;

    /**
     * @ORM\OneToMany(targetEntity=DescriptionTranslation::class, mappedBy="entity", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private Collection $translations;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private ?string $type = null;

    public function __construct()
    {
        $this->hasImages = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function createHasImage(): DescriptionHasImages
    {
        return new DescriptionHasImages();
    }

    public function createTranslation(): TranslatableInterface
    {
        return new DescriptionTranslation();
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }
}
