<?php

declare(strict_types=1);

namespace App\Controller\Site\Api;

use App\Handler\Site\ContactHandler;
use App\Parser\Site\ContactRequestParser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ContactController extends AbstractController
{
    private ContactRequestParser $requestParser;

    private ContactHandler $handler;

    public function __construct(
        ContactRequestParser $requestParser,
        ContactHandler $handler
    ) {
        $this->requestParser = $requestParser;
        $this->handler = $handler;
    }

    /**
     * @Route({
     *          "rs": "/api/contact",
     *          "en": "/api/contact"
     *      },
     *     name="site_api.contact",
     *     methods={"POST"},
     *     options={"expose": true}
     * )
     * @param Request $request
     *
     * @return JsonResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \ReflectionException
     */
    public function add(Request $request): JsonResponse
    {
        $askUs = $this->requestParser->parse($request->request);

        $this->handler->save($askUs);

        return $this->json(null, Response::HTTP_CREATED);
    }
}
