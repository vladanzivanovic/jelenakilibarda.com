<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api;

use App\Formatter\Admin\VideoDataTableResponseFormatter;
use App\Parser\DataTableRequestParser;
use App\Repository\SliderRepository;
use App\Repository\VideoRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class VideoListController extends AbstractController
{
    private DataTableRequestParser $requestParser;

    private VideoDataTableResponseFormatter $responseFormatter;

    private VideoRepository $videoRepository;

    public function __construct(
        DataTableRequestParser $requestParser,
        VideoDataTableResponseFormatter $responseFormatter,
        VideoRepository $videoRepository
    ) {
        $this->requestParser = $requestParser;
        $this->responseFormatter = $responseFormatter;
        $this->videoRepository = $videoRepository;
    }

    /**
     * @Route("/api/get-video-list", name="admin.get_video_list", methods={"POST"}, options={"expose": true})
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getList(Request $request): JsonResponse
    {
        $formattedRequest = $this->requestParser->formatRequest($request);
        $total = $this->videoRepository->countData();

        $data = $this->videoRepository->getAdminList($formattedRequest);

        $response = $this->responseFormatter->formatResponse($formattedRequest, $data, (int)$total);

        return new JsonResponse($response);
    }
}
