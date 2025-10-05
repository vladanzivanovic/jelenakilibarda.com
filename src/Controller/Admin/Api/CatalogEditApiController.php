<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api;

use App\Handler\CatalogHandler;
use App\Parser\CatalogEditRequestParser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CatalogEditApiController extends AbstractController
{
    private CatalogHandler $handler;

    private CatalogEditRequestParser $requestParser;

    public function __construct(
        CatalogHandler $handler,
        CatalogEditRequestParser $requestParser
    ) {
        $this->handler = $handler;
        $this->requestParser = $requestParser;
    }

    /**
     * @Route("/api/save-catalog", name="admin.save_catalog_api", methods={"POST"}, options={"expose": true})
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Exception
     */
    public function save(Request $request): JsonResponse
    {
        $images = $this->requestParser->parse($request->request);

        $this->handler->save($images);

        return $this->json(null, Response::HTTP_CREATED);
    }
}
