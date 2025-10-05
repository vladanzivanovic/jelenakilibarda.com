<?php

declare(strict_types=1);

namespace App\Twig;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class LocalizationUrlExtension extends AbstractExtension
{
    private RouterInterface $router;

    private TranslatorInterface $translator;

    private array $siteInfoTexts;

    public function __construct(
        RouterInterface $router,
        TranslatorInterface $translator,
        array $siteInfoTexts
    ) {
        $this->router = $router;
        $this->translator = $translator;
        $this->siteInfoTexts = $siteInfoTexts;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('url_locale', [$this, 'generateUrlLocale']),
        ];
    }

    public function generateUrlLocale(string $routeName, array $routeParams, string $fromLocale, string $toLocale)
    {
//        if (($routeName === 'site.shop_page' || $routeName === 'site.trendy_page') && isset($routeParams['searchData'])) {
//            try {
//                $routeParams['searchData'] = $this->shopPageRouterFormatter->localeFormatter($routeParams['searchData'], $toLocale);
//            } catch (\Throwable $exception) {
//                var_dump($exception->getMessage());
//            }
//        }
//
//        if ($routeName === 'site.blog_list_page' && isset($routeParams['tag'])) {
//            $routeParams['tag'] = $this->blogListRouterFormatter->localeFormatter($routeParams['tag'], $toLocale);
//        }
//
//        if ($routeName === 'site.product_page') {
//            $routeParams['slug'] = $this->productPageRouterFormatter->localeFormatter($routeParams['slug'], $toLocale);
//        }
//
//        if ($routeName === 'site.blog_detailed_page') {
//            $routeParams['slug'] = $this->blogPageRouterFormatter->localeFormatter($routeParams['slug'], $toLocale);
//        }
//
//        if ($routeName === 'site.info_texts') {
//            $routeParams['slug'] = $this->getTextLocaleSlug($routeParams['slug'], $fromLocale, $toLocale);
//        }
//
//        if ($toLocale != 'rs') {
//            $routeParams['_locale'] = $toLocale;
//            $routeName = $this->getRouteName($routeName, $toLocale);
//
//        }
//
//        if ($toLocale === 'rs') {
//            unset($routeParams['_locale']);
//            $routeName = $this->getRouteName(str_replace('site_locale_', '', $routeName), 'rs');
//        }
        $routeParams['_locale'] = $toLocale;

        return $this->router->generate($routeName, $routeParams);
    }

    private function getRouteName(string $routeName, string $locale)
    {
        $routeCollection = $this->router->getRouteCollection();
        $route = $routeCollection->get($routeName);

        if (!$route instanceof Route) {
            $routeCollection->get($routeName.'.'.$locale);
            $routeName = $routeName.'.'.$locale;
        }

        return $routeName;
    }

    private function getTextLocaleSlug(string $slug, string $fromLocale, string $toLocale): ?string
    {
        foreach ($this->siteInfoTexts as $infoText) {
            if ($infoText['slug'][$fromLocale] === $slug) {
                return $infoText['slug'][$toLocale];
            }
        }

        return null;
    }


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'localized_url_extension';
    }
}
