<?php

namespace App\Entity;

use App\Entity\Traits\ResourceTrait;
use App\Entity\Traits\TranslatableTrait;
use App\Repository\DescriptionTranslationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DescriptionTranslationRepository::class)
 */
class DescriptionTranslation implements EntityInterface, TranslatableInterface
{
    use ResourceTrait;
    use TranslatableTrait;

    /**
     * @ORM\ManyToOne(targetEntity=Description::class, inversedBy="translations", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private ?EntityInterface $entity = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $shortDescription = null;

    /**
     * @ORM\Column(type="text")
     */
    private string $description;

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
