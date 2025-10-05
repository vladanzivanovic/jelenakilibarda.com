<?php

declare(strict_types=1);

namespace App\Controller\Site;

use App\Collector\Site\DescriptionPageCollector;
use App\Collector\Site\HomePageCollector;
use App\Formatter\Site\DescriptionPageResponseFormatter;
use App\Formatter\Site\HomePageResponseFormatter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class DescriptionPageController extends AbstractController
{
    private DescriptionPageCollector $pageCollectors;

    private DescriptionPageResponseFormatter $responseFormatter;

    public function __construct(
        DescriptionPageCollector $pageCollectors,
        DescriptionPageResponseFormatter $responseFormatter
    ) {
        $this->pageCollectors = $pageCollectors;
        $this->responseFormatter = $responseFormatter;
    }

    /**
     * @Route({
     *          "rs": "/biografija",
     *          "en": "/biography"
     *     },
     *     name="site.biography_page",
     *     methods={"GET"},
     *     options={"expose": true}
     *     )
     * @Route({
     *          "rs": "/repertoar",
     *          "en": "/repertoire"
     *     },
     *     name="site.repertoire_page",
     *     methods={"GET"},
     *     options={"expose": true}
     *     )
     * @Route({
     *          "rs": "/klavirski-duo-jasmina-krstic-i-jelena-kilibarda",
     *          "en": "/piano-duo-jasmina-krstic-and-jelena-kilibarda"
     *     },
     *     name="site.piano_duo_page",
     *     methods={"GET"},
     *     options={"expose": true}
     *     )
     * @Template("Site/Pages/description.html.twig")
     *
     * @param Request $request
     *
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function index(Request $request): array
    {
        $type = str_replace(['site.', '_page'], '', $request->attributes->get('_route'));

        $data = $this->pageCollectors->collect($request->getLocale(), $type);

        return $this->responseFormatter->formatResponse($data);
    }
}
