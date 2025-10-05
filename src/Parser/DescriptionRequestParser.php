<?php

declare(strict_types=1);

namespace App\Parser;

use App\Entity\Description;
use App\Entity\DescriptionTranslation;
use App\Entity\EntityInterface;
use App\Handler\ImageHandler;
use App\Repository\DescriptionHasImagesRepository;
use App\Repository\DescriptionRepository;
use App\Repository\DescriptionTranslationRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

class DescriptionRequestParser implements RequestParserInterface
{
    use ParserTrait;

    private ParameterBagInterface $parameterBag;

    private DescriptionRepository $descriptionRepository;

    private ImageHandler $imageHandler;

    private DescriptionHasImagesRepository $hasImagesRepository;

    private DescriptionTranslationRepository $translationRepository;

    private array $languages;

    private string $defaultLocale;

    public function __construct(
        ParameterBagInterface $parameterBag,
        DescriptionRepository $descriptionRepository,
        ImageHandler $imageHandler,
        DescriptionHasImagesRepository $hasImagesRepository,
        DescriptionTranslationRepository $translationRepository,
        array $languages,
        string $defaultLocale
    ) {
        $this->parameterBag = $parameterBag;
        $this->descriptionRepository = $descriptionRepository;
        $this->imageHandler = $imageHandler;
        $this->hasImagesRepository = $hasImagesRepository;
        $this->languages = $languages;
        $this->defaultLocale = $defaultLocale;
        $this->translationRepository = $translationRepository;
    }

    /**
     * @param ParameterBag $bag
     *
     * @return void
     * @throws \Doctrine\ORM\ORMException
     */
    public function parse(ParameterBag $bag, EntityInterface $entity = null): EntityInterface
    {
        if (!$entity instanceof Description) {
            $entity = $this->create();
        }

        $entity->setType($bag->get('type'));

        $this->setTranslation($entity, $bag);

        $this->imageHandler->setImages(
            $entity,
            json_decode($bag->get('images'), true),
            $this->hasImagesRepository
        );

        return $entity;
    }

    public function create(): Description
    {
        return new Description();
    }

    private function setTranslation(Description $biography, ParameterBag $bag)
    {
        foreach ($this->languages as $language) {
            $langCode = $language['code'];

            $translation = $this->translationRepository->findOneBy(['entity' => $biography, 'locale' => $langCode]);

            if (!$translation instanceof DescriptionTranslation) {
                $translation = $biography->createTranslation();
                $this->translationRepository->persist($translation);
            }

            $translation->setLocale($langCode);
            if ($bag->has('short_description_'.$langCode)) {
                $translation->setShortDescription($bag->get('short_description_' . $langCode));
            }

            $translation->setDescription($bag->get('description_'.$langCode));

            $biography->addTranslation($translation);
        }
    }
}
