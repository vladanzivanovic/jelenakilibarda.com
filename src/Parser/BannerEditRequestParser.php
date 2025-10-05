<?php

declare(strict_types=1);

namespace App\Parser;

use App\Entity\Banner;
use App\Entity\BannerTranslation;
use App\Entity\CategoryTranslation;
use App\Entity\EntityInterface;
use App\Entity\Image;
use App\Repository\BannerRepository;
use App\Services\BannerImageService;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

final class BannerEditRequestParser
{
    use ParserTrait;

    private ParameterBagInterface $parameterBag;

    private BannerImageService $imageService;

    private BannerRepository $bannerRepository;

    private array $languages;

    public function __construct(
        ParameterBagInterface $parameterBag,
        BannerImageService $imageService,
        BannerRepository $bannerRepository,
        array $languages
    ) {
        $this->parameterBag = $parameterBag;
        $this->imageService = $imageService;
        $this->bannerRepository = $bannerRepository;
        $this->languages = $languages;
    }

    /**
     * @param ParameterBag $bag
     * @param Banner|null  $banner
     *
     * @return Banner
     * @throws \Doctrine\ORM\ORMException
     */
    public function parse(ParameterBag $bag, Banner $banner = null): Banner
    {
        if (!$banner instanceof Banner) {
            $banner = new Banner();
            $banner->setStatus(EntityInterface::STATUS_PENDING);
        }

        $banner->setPosition($bag->getInt('position'));
        $banner->setType($bag->getInt('type'));

        $this->setLocale($bag, $banner);

        $this->imageService->setImages($banner, json_decode($bag->get('images'), true), Image::DEVICE_DESKTOP);

        if ($bag->has('images_mobile')) {
            $this->imageService->setImages($banner, json_decode($bag->get('images_mobile'), true), Image::DEVICE_MOBILE);
        }

        return $banner;
    }

    private function setLocale(ParameterBag $bag, Banner $banner)
    {
        foreach ($this->languages as $language) {
            $langCode = $language['code'];

            $trans = new BannerTranslation();

            if (null !== $banner->getId()) {
                $trans = $banner->getTranslationByLocale($langCode);
            }

            $trans->setDescription($bag->get($langCode.'_description', ''));
            $trans->setButtonText($bag->get($langCode.'_button'));
            $trans->setButtonLink($bag->get($langCode.'_link'));
            $trans->setLocale($langCode);

            $banner->addBannerTranslation($trans);
        }
    }
}
