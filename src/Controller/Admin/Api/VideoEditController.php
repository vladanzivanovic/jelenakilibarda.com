<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api;

use App\Entity\EntityInterface;
use App\Entity\Video;
use App\Handler\VideoEditHandler;
use App\Helper\ConstantsHelper;
use App\Parser\RequestParserInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VideoEditController extends AbstractController
{
    private RequestParserInterface $requestParser;

    private VideoEditHandler $videoEditHandler;

    public function __construct(
        RequestParserInterface $videoEditRequestParser,
        VideoEditHandler $videoEditHandler
    ) {
        $this->requestParser = $videoEditRequestParser;
        $this->videoEditHandler = $videoEditHandler;
    }

    /**
     * @Route("/api/add-video", name="admin.add_video_api", methods={"POST"}, options={"expose": true})
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws \Exception
     */
    public function insert(Request $request): JsonResponse
    {
        $biography = $this->requestParser->parse($request->request);

        $this->videoEditHandler->save($biography);

        return $this->json(null, Response::HTTP_CREATED);
    }

    /**
     * @Route("/api/toggle-video-status/{id}/{status}", name="admin.api_toggle_video_status", methods={"PATCH"},
     *                                                   options={"expose": true})
     *
     * @return JsonResponse
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \ReflectionException
     */
    public function toggleActivation(Video $video, int $status): JsonResponse
    {
        $video->setStatus($status);

        $this->videoEditHandler->save($video);

        $statusText = ConstantsHelper::getConstantName((string) $status, 'STATUS', EntityInterface::class);

        return $this->json(['text' => $statusText]);
    }
}
