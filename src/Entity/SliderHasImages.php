<?php

namespace App\Entity;

use App\Entity\Traits\ResourceTrait;
use App\Repository\BiographyHasImagesRepository;
use App\Repository\HasImageRepositoryInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SliderHasImagesRepository::class)
 */
class SliderHasImages implements HasImageEntityInterface
{
    use ResourceTrait;

    /**
     * @ORM\ManyToOne(targetEntity=Slider::class, inversedBy="hasImages")
     * @ORM\JoinColumn(nullable=false)
     */
    private EntityInterface $entity;

    /**
     * @ORM\OneToOne(targetEntity=Image::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
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
