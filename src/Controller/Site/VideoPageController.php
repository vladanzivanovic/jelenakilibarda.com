<?php

declare(strict_types=1);

namespace App\Controller\Site;

use App\Collector\Site\VideoPageCollector;
use App\Formatter\Site\VideoPageResponseFormatter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class VideoPageController extends AbstractController
{
    private VideoPageCollector $pageCollectors;

    private VideoPageResponseFormatter $responseFormatter;

    public function __construct(
        VideoPageCollector $pageCollectors,
        VideoPageResponseFormatter $responseFormatter
    ) {
        $this->pageCollectors = $pageCollectors;
        $this->responseFormatter = $responseFormatter;
    }

    /**
     * @Route({
     *          "rs": "/video-galerija",
     *          "en": "/video-gallery"
     *     },
     *     name="site.video_page",
     *     methods={"GET"},
     *     options={"expose": true}
     *     )
     * @Template("Site/Pages/videos.html.twig")
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
