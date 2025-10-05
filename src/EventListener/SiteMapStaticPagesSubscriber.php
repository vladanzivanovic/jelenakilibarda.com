<?php

namespace App\EventListener;

use DateTime;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Sitemap\Url\GoogleMultilangUrlDecorator;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class SiteMapStaticPagesSubscriber implements EventSubscriberInterface
{
    private UrlGeneratorInterface $urlGenerator;

    private ParameterBagInterface $parameterBag;

    public function __construct(
        UrlGeneratorInterface $urlGenerator,
        ParameterBagInterface $parameterBag,
        TranslatorInterface $translator
    ) {
        $this->urlGenerator = $urlGenerator;
        $this->parameterBag = $parameterBag;
    }

    public static function getSubscribedEvents()
    {
        return [
            SitemapPopulateEvent::ON_SITEMAP_POPULATE => [
                ['registerStaticUrl'],
            ],
        ];
    }

    public function registerStaticUrl(SitemapPopulateEvent $event)
    {
       $this->_registerStaticUrl($event, 'site.home_page', UrlConcrete::CHANGEFREQ_WEEKLY, 0.7);
       $this->_registerStaticUrl($event, 'site.biography_page', UrlConcrete::CHANGEFREQ_NEVER, 0.1);
       $this->_registerStaticUrl($event, 'site.gallery_page', UrlConcrete::CHANGEFREQ_NEVER, 0.1);
       $this->_registerStaticUrl($event, 'site.video_page', UrlConcrete::CHANGEFREQ_NEVER, 0.1);
    }

    private function _registerStaticUrl(SitemapPopulateEvent $event, string $routeName, $changeFreq, $priority)
    {
        $locales = explode('|', $this->parameterBag->get('locales'));
        $baseUrl = $this->parameterBag->get('url');

        foreach ($locales as $locale) {
            if ($locale === 'rs') {
                continue;
            }
            $url = new UrlConcrete($baseUrl.$this->urlGenerator->generate(
                $routeName,
                [],
                UrlGeneratorInterface::RELATIVE_PATH
            ),
                new DateTime(),
                $changeFreq,
                $priority
            );
            $decoratedUrl = new GoogleMultilangUrlDecorator($url);
            $decoratedUrl->addLink($baseUrl.$this->urlGenerator->generate(
                $routeName,
                ['_locale' => $locale],
                UrlGeneratorInterface::RELATIVE_PATH
            ), $locale);

            $event->getUrlContainer()->addUrl($decoratedUrl, 'default');
        }
    }
}
