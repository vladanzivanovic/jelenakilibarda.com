<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api;

use App\Entity\Description;
use App\Handler\DescriptionHandler;
use App\Parser\RequestParserInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DescriptionEditController extends AbstractController
{
    private RequestParserInterface $requestParser;

    private DescriptionHandler $handler;

    public function __construct(
        RequestParserInterface $descriptionRequestParser,
        DescriptionHandler $handler
    ) {
        $this->requestParser = $descriptionRequestParser;
        $this->handler = $handler;
    }

    /**
     * @Route("/api/add-description", name="admin.add_description_api", methods={"POST"}, options={"expose": true})
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function insert(Request $request): JsonResponse
    {
        $description = $this->requestParser->parse($request->request);

        $this->handler->save($description);

        return $this->json(null, Response::HTTP_CREATED);
    }

    /**
     * @Route("/api/edit-description/{id}", name="admin.edit_description_api", methods={"PUT"}, options={"expose": true})
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function update(Request $request, Description $description): JsonResponse
    {
        $description = $this->requestParser->parse($request->request, $description);

        $this->handler->save($description);

        return $this->json(null, Response::HTTP_CREATED);
    }
}
