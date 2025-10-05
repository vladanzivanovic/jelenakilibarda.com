<?php

namespace App\Entity;

use App\Entity\Traits\ResourceTrait;
use App\Entity\Traits\StatusTrait;
use App\Entity\Traits\TranslationTrait;
use App\Repository\VideoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use SiteBundle\Entity\Youtubeinfo;

/**
 * @ORM\Entity(repositoryClass=VideoRepository::class)
 */
class Video implements EntityInterface, TranslationInterface
{
    use ResourceTrait;
    use TranslationTrait;
    use StatusTrait;

    /**
     * @ORM\OneToMany(targetEntity=VideoTranslation::class, mappedBy="entity", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private Collection $translations;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private ?string $youtubeId = null;

    /**
     * @ORM\Column(type="string", length=250, nullable=false)
     */
    private ?string $channelId = null;

    /**
     * @ORM\Column(type="string", length=250, nullable=false)
     */
    private ?string $channelTitle = null;

    /**
     * @ORM\Column(type="json", length=65535, nullable=false)
     */
    private array $thumbnails = [];

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function createTranslation(): TranslatableInterface
    {
        return new VideoTranslation();
    }

    public function setYoutubeId(string $youtubeId): void
    {
        $this->youtubeId = $youtubeId;
    }

    public function getYoutubeId(): ?string
    {
        return $this->youtubeId;
    }

    public function setChannelId(string $channelId): void
    {
        $this->channelId = $channelId;
    }

    public function getChannelId(): ?string
    {
        return $this->channelId;
    }

    public function setChannelTitle(string $channelTitle): void
    {
        $this->channelTitle = $channelTitle;
    }

    public function getChanelTitle(): ?string
    {
        return $this->channelTitle;
    }

    public function setThumbnails(array $thumbnails): void
    {
        $this->thumbnails = $thumbnails;
    }

    public function getThumbnails(): array
    {
        return $this->thumbnails;
    }
}
