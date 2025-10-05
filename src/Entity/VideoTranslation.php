<?php

namespace App\Entity;

use App\Entity\Traits\ResourceTrait;
use App\Entity\Traits\TranslatableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VideoTranslationRepository")
 */
class VideoTranslation implements EntityInterface, TranslatableInterface
{
    use ResourceTrait;
    use TranslatableTrait;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $description = null;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private ?string $title = null;

    /**
     * @ORM\ManyToOne(targetEntity=Video::class, inversedBy="translations")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?EntityInterface $entity = null;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
