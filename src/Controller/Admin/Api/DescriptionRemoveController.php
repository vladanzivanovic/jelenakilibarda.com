<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api;

use App\Entity\Description;
use App\Handler\DescriptionHandler;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DescriptionRemoveController extends AbstractController
{
    private DescriptionHandler $handler;

    public function __construct(
        DescriptionHandler $handler
    ) {
        $this->handler = $handler;
    }

    /**
     * @Route("/api/description-remove/{id}", name="admin.remove_description_api", methods={"DELETE"}, options={"expose": true})
     *
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Description $description): JsonResponse
    {

        $this->handler->remove($description);

        return $this->json(null);
    }
}
