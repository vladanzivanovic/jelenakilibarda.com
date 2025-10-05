<?php

declare(strict_types=1);

namespace App\Parser;

use App\Entity\EntityInterface;
use App\Entity\Video;
use App\Entity\VideoTranslation;
use App\Repository\VideoTranslationRepository;
use Symfony\Component\HttpFoundation\ParameterBag;

class VideoEditRequestParser implements RequestParserInterface
{
    private VideoTranslationRepository $translationRepository;

    private array $languages;

    private string $defaultLocale;

    public function __construct(
        VideoTranslationRepository $translationRepository,
        array $languages,
        string $defaultLocale
    ) {
        $this->translationRepository = $translationRepository;
        $this->languages = $languages;
        $this->defaultLocale = $defaultLocale;
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     */
    public function parse(ParameterBag $bag, EntityInterface $entity = null): Video
    {
        if (!$entity instanceof Video) {
            $entity = $this->create();
        }

        $videoArray = json_decode($bag->get('video'), true);

        $entity->setChannelId($videoArray[0]['ChannelId']);
        $entity->setChannelTitle($videoArray[0]['ChanelTitle']);
        $entity->setYoutubeId($videoArray[0]['YouTubeId']);
        $entity->setThumbnails($videoArray[0]['Thumbnails']);

        $this->setTranslation($entity, $bag);

        return $entity;
    }

    public function create(): EntityInterface
    {
        return new Video();
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     */
    private function setTranslation(Video $video, ParameterBag $bag): void
    {
        foreach ($this->languages as $language) {
            $langCode = $language['code'];

            $translation = $this->translationRepository->findOneBy(['entity' => $video, 'locale' => $langCode]);

            if (!$translation instanceof VideoTranslation) {
                $translation = $video->createTranslation();
                $this->translationRepository->persist($translation);
            }

            $translation->setLocale($langCode);
            $translation->setTitle($bag->get('title_'.$langCode));
            $translation->setDescription($bag->get('description_'.$langCode));

            $video->addTranslation($translation);
        }
    }
}
