<?php

declare(strict_types=1);

namespace App\Parser;

use App\Entity\EntityInterface;
use App\Entity\Image;
use App\Entity\Slider;
use App\Entity\SliderTranslation;
use App\Handler\ImageHandler;
use App\Repository\SliderHasImagesRepository;
use App\Repository\SliderRepository;
use App\Repository\SliderTranslationRepository;
use App\Services\SliderImageService;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

final class SliderEditRequestParser implements RequestParserInterface
{
    use ParserTrait;

    private ParameterBagInterface $parameterBag;

    private ImageHandler $imageHandler;

    private SliderRepository $sliderRepository;

    private SliderTranslationRepository $translationRepository;

    private SliderHasImagesRepository $hasImagesRepository;

    /**
     * @var array<int, array<string, string>>
     */
    private array $languages;

    public function __construct(
        ParameterBagInterface $parameterBag,
        ImageHandler $imageHandler,
        SliderRepository $sliderRepository,
        SliderTranslationRepository $translationRepository,
        SliderHasImagesRepository $hasImagesRepository,
        array $languages
    ) {
        $this->parameterBag = $parameterBag;
        $this->imageHandler = $imageHandler;
        $this->sliderRepository = $sliderRepository;
        $this->languages = $languages;
        $this->translationRepository = $translationRepository;
        $this->hasImagesRepository = $hasImagesRepository;
    }

    /**
     * @param ParameterBag         $bag
     * @param EntityInterface|null $entity
     *
     * @return Slider
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     */
    public function parse(ParameterBag $bag, EntityInterface $entity = null): Slider
    {
        if (!$entity instanceof Slider) {
            $lastPosition = $this->sliderRepository->getLastPosition();
            $newPosition = count($lastPosition) === 1 ? $lastPosition[0]['position'] + 1 : 1;

            $entity = $this->create();
            $entity->setStatus(EntityInterface::STATUS_PENDING);
            $entity->setPosition($newPosition);
        }

        $entity->setPage($bag->get('page'));
        $entity->setTextPosition($bag->getInt('position'));

        $this->setTranslations($entity, $bag);

        $this->imageHandler->setImages(
            $entity,
            json_decode($bag->get('images'), true),
            $this->hasImagesRepository
        );

        $this->imageHandler->setImages(
            $entity,
            json_decode($bag->get('images_mobile'), true),
            $this->hasImagesRepository,
            Image::DEVICE_MOBILE
        );

        return $entity;
    }

    /**
     * @param Slider       $slider
     * @param ParameterBag $bag
     */
    private function setTranslations(Slider $slider, ParameterBag $bag): void
    {
        foreach ($this->languages as $language) {
            $langCode = $language['code'];

            $translation = $this->translationRepository->findOneBy(['entity' => $slider, 'locale' => $langCode]);

            if (!$translation instanceof SliderTranslation) {
                $translation = $slider->createTranslation();
            }

            $translation->setLocale($langCode);
            $translation->setButtonText($bag->get($langCode.'_button'));
            $translation->setButtonLink($bag->get($langCode.'_link'));
            $translation->setDescription($bag->get($langCode.'_description'));

            $slider->addTranslation($translation);
        }
    }

    public function create(): Slider
    {
        return new Slider();
    }
}
