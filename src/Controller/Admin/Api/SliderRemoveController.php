<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api;

use App\Entity\Slider;
use App\Handler\SliderHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class SliderRemoveController extends AbstractController
{
    private SliderHandler $sliderHandler;

    public function __construct(
        SliderHandler $sliderHandler
    ) {
        $this->sliderHandler = $sliderHandler;
    }

    /**
     * @Route("/api/remove-slider/{id}", name="admin.remove_slider_api", methods={"DELETE"}, options={"expose": true})
     *
     * @param Slider $slider
     *
     * @return JsonResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(Slider $slider): JsonResponse
    {
        $this->sliderHandler->remove($slider);

        return $this->json(null);
    }
}
