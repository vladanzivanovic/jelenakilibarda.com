<?php

namespace App\Entity;

use App\Entity\Traits\ResourceTrait;
use App\Repository\DescriptionHasImagesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DescriptionHasImagesRepository::class)
 */
class DescriptionHasImages implements HasImageEntityInterface
{
    use ResourceTrait;

    /**
     * @ORM\ManyToOne(targetEntity=Description::class, inversedBy="hasImages")
     * @ORM\JoinColumn(nullable=true)
     */
    private EntityInterface $entity;

    /**
     * @ORM\OneToOne(targetEntity=Image::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Image $image = null;

    public function getEntity(): ?EntityInterface
    {
        return $this->entity;
    }

    public function setEntity(?EntityInterface $entity): self
    {
        $this->entity = $entity;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(Image $image): self
    {
        $this->image = $image;

        return $this;
    }
}
