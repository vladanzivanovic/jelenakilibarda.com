<?php

namespace App\Entity;

use App\Entity\Traits\ResourceTrait;
use App\Entity\Traits\TranslatableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SliderTranslationRepository")
 */
class SliderTranslation implements EntityInterface, TranslatableInterface
{
    use ResourceTrait;
    use TranslatableTrait;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description = null;

    /**
     * @ORM\Column(type="string", nullable=true, length=100)
     */
    private ?string $buttonText = null;

    /**
     * @ORM\Column(type="string", nullable=true, length=255)
     */
    private ?string $buttonLink = null;

    /**
     * @ORM\ManyToOne(targetEntity=Slider::class, inversedBy="translations")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?EntityInterface $entity = null;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getButtonText(): ?string
    {
        return $this->buttonText;
    }

    public function setButtonText(?string $buttonText): self
    {
        $this->buttonText = $buttonText;

        return $this;
    }

    public function getButtonLink(): ?string
    {
        return $this->buttonLink;
    }

    public function setButtonLink(?string $buttonLink): self
    {
        $this->buttonLink = $buttonLink;

        return $this;
    }
}
