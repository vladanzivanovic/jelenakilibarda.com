<?php

declare(strict_types=1);

namespace App\Controller\Site;

use App\Collector\Site\GalleryPageCollector;
use App\Formatter\Site\GalleryPageResponseFormatter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class GalleryPageController extends AbstractController
{
    private GalleryPageCollector $pageCollectors;

    private GalleryPageResponseFormatter $responseFormatter;

    public function __construct(
        GalleryPageCollector $pageCollectors,
        GalleryPageResponseFormatter $responseFormatter
    ) {
        $this->pageCollectors = $pageCollectors;
        $this->responseFormatter = $responseFormatter;
    }

    /**
     * @Route({
     *          "rs": "/galerija",
     *          "en": "/gallery"
     *     },
     *     name="site.gallery_page",
     *     methods={"GET"},
     *     options={"expose": true}
     *     )
     * @Template("Site/Pages/gallery.html.twig")
     *
     * @param Request $request
     *
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function index(Request $request): array
    {
        $data = $this->pageCollectors->collect($request->getLocale());

        return $this->responseFormatter->formatResponse($data);
    }
}
