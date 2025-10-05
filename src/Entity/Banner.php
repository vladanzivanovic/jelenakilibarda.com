<?php

namespace App\Entity;

use App\Entity\Traits\ResourceTrait;
use App\Entity\Traits\StatusTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BannerRepository")
 */
class Banner implements EntityInterface, TranslationInterface
{
    use ResourceTrait;
    use StatusTrait;

    public const POSITION_HOME_LEFT = 1;
    public const POSITION_HOME_MIDDLE_UP = 2;
    public const POSITION_HOME_MIDDLE_DOWN = 3;
    public const POSITION_HOME_RIGHT = 4;

    public const TYPE_SPEED_LINKS = 1;
    public const TYPE_LOYALTY = 2;
    public const TYPE_NEWS_LETTER = 3;
    public const TYPE_POP_UP = 4;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $image;

    /**
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BannerTranslation", mappedBy="banner", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $bannerTranslations;

    /**
     * @ORM\Column(type="smallint")
     */
    private $type;

    public function __construct()
    {
        $this->bannerTranslations = new ArrayCollection();
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

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return Collection|BannerTranslation[]
     */
    public function getBannerTranslations(): Collection
    {
        return $this->bannerTranslations;
    }

    public function addBannerTranslation(BannerTranslation $bannerTranslation): self
    {
        if (!$this->bannerTranslations->contains($bannerTranslation)) {
            $this->bannerTranslations[] = $bannerTranslation;
            $bannerTranslation->setBanner($this);
        }

        return $this;
    }

    public function removeBannerTranslation(BannerTranslation $bannerTranslation): self
    {
        if ($this->bannerTranslations->contains($bannerTranslation)) {
            $this->bannerTranslations->removeElement($bannerTranslation);
            // set the owning side to null (unless already changed)
            if ($bannerTranslation->getBanner() === $this) {
                $bannerTranslation->setBanner(null);
            }
        }

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTranslationByLocale(string $locale): ?BannerTranslation
    {
        $filteredCollection = $this->bannerTranslations->filter(function ($item) use ($locale) {
            /** @var BannerTranslation $item */
            return $item->getLocale() == $locale;
        });

        return $filteredCollection->count() > 0 ? $filteredCollection->first() : null;
    }

    public function createTranslation(): TranslatableInterface
    {
        // TODO: Implement createTranslation() method.
    }
}
